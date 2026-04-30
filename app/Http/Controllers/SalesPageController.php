<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SalesPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();
        $salesPages = SalesPage::where('user_id', $userId)->latest()->get();
        
        return view('sales_pages.index', compact('salesPages'));
    }

    public function create()
    {
        // Daftar mata uang populer dunia (bisa ditambah sesuai kebutuhan)
        $currencies = [
            'USD' => 'United States Dollar ($)',
            'EUR' => 'Euro (€)',
            'GBP' => 'British Pound (£)',
            'IDR' => 'Indonesian Rupiah (Rp)',
            'JPY' => 'Japanese Yen (¥)',
            'SAR' => 'Saudi Riyal (SR)',
            'SGD' => 'Singapore Dollar (S$)',
            'AUD' => 'Australian Dollar (A$)',
            'CAD' => 'Canadian Dollar (C$)',
            'CNY' => 'Chinese Yuan (¥)',
            // Kamu bisa cari list lengkap ISO 4217 di internet dan tempel di sini
        ];

        return view('sales_pages.create', compact('currencies'));
    }

    public function store(Request $request)
    {
        // 1. Validasi: Tambahkan 'currency' di sini
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'nullable|string',
            'target_audience' => 'nullable|string',
            'price' => 'nullable|string',
            'currency' => 'required|string|max:3', // UPDATE: Validasi currency
            'template' => 'required|string',
            'unique_selling_points' => 'nullable|string',
        ]);

        // 2. Siapkan instruksi untuk AI
        // Tips: Beri tahu AI mata uangnya apa agar copywriting-nya lebih nyambung
        $prompt = "Create a professional sales page content in English. 
        Product: {$request->product_name}
        Description: {$request->description}
        Features: {$request->features}
        Target: {$request->target_audience}
        Price: {$request->currency} {$request->price} 
        USP: {$request->unique_selling_points}

        Return ONLY raw JSON format. 
        CRITICAL: The 'benefits' array MUST contain EXACTLY 3 points. No more, no less.

        {
            \"headline\": \"...\",
            \"subheadline\": \"...\",
            \"benefits\": [\"Point 1\", \"Point 2\", \"Point 3\"],
            \"cta\": \"...\",
            \"social_proof\": \"...\"
        }";

        // 3. Panggil Gemini API
        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=" . config('services.gemini.key');

        $response = Http::withoutVerifying()->post($url, [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ]
        ]);

        $rawText = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // Menggunakan Regex untuk mengambil teks di antara kurung kurawal { ... }
        // Ini sangat ampuh membuang teks sampah dari AI
        preg_match('/\{.*\}/s', $rawText, $matches);
        $cleanJson = $matches[0] ?? '{}';

        // 4. Simpan ke database: Masukkan 'currency' ke dalam array create
        $salesPage = SalesPage::create([
            'user_id' => Auth::id(),
            'product_name' => $request->product_name,
            'description' => $request->description,
            'features' => $request->features,
            'target_audience' => $request->target_audience,
            'price' => $request->price,
            'currency' => $request->currency, // UPDATE: Simpan currency yang dipilih
            'template' => $request->template,
            'unique_selling_points' => $request->unique_selling_points,
            'generated_content' => $cleanJson,
        ]);

        return redirect()->route('sales-pages.show', $salesPage->id);
    }

    public function show($id)
    {
        $salesPage = SalesPage::where('user_id', Auth::id())->findOrFail($id);
        
        // Berikan fallback [] (array kosong) jika json_decode menghasilkan null
        $content = json_decode($salesPage->generated_content, true) ?: [];

        return view('sales_pages.show', compact('salesPage', 'content'));
    }

    public function destroy($id)
    {
        $page = SalesPage::where('user_id', Auth::id())->findOrFail($id);
        $page->delete();

        return redirect()->route('sales-pages.index')->with('success', 'Page deleted successfully.');
    }

    public function edit($id)
    {
        // Pastikan hanya pemilik yang bisa edit
        $salesPage = SalesPage::where('user_id', Auth::id())->findOrFail($id);
        
        $currencies = [
            'USD' => 'United States Dollar ($)',
            'EUR' => 'Euro (€)',
            'GBP' => 'British Pound (£)',
            'IDR' => 'Indonesian Rupiah (Rp)',
            'JPY' => 'Japanese Yen (¥)',
            'SAR' => 'Saudi Riyal (SR)',
            'SGD' => 'Singapore Dollar (S$)',
            'AUD' => 'Australian Dollar (A$)',
            'CAD' => 'Canadian Dollar (C$)',
            'CNY' => 'Chinese Yuan (¥)',
        ];

        // Kita kirim data $salesPage ke view create yang nanti akan kita modifikasi
        return view('sales_pages.create', compact('salesPage', 'currencies'));
    }

    public function update(Request $request, $id)
    {
        $salesPage = SalesPage::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'currency' => 'required|string|max:3',
            'template' => 'required|string',
            'price' => 'nullable|string',
        ]);

        // Jalankan AI lagi dengan input yang sudah diubah oleh user
        $prompt = "Create a professional sales page content in English. 
        Product: {$request->product_name}
        Description: {$request->description}
        Features: {$request->features}
        Target: {$request->target_audience}
        Price: {$request->currency} {$request->price} 
        USP: {$request->unique_selling_points}

        Return ONLY raw JSON format:
        {
            \"headline\": \"...\",
            \"subheadline\": \"...\",
            \"benefits\": [\"...\", \"...\", \"...\"],
            \"cta\": \"...\",
            \"social_proof\": \"...\"
        }";

        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=" . config('services.gemini.key');

        $response = Http::withoutVerifying()->post($url, [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ]
        ]);

        $rawText = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // Menggunakan Regex untuk mengambil teks di antara kurung kurawal { ... }
        // Ini sangat ampuh membuang teks sampah dari AI
        preg_match('/\{.*\}/s', $rawText, $matches);
        $cleanJson = $matches[0] ?? '{}';

        // Update data lama dengan hasil generate yang baru
        $salesPage->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'features' => $request->features,
            'target_audience' => $request->target_audience,
            'price' => $request->price,
            'currency' => $request->currency,
            'template' => $request->template,
            'unique_selling_points' => $request->unique_selling_points,
            'generated_content' => $cleanJson,
        ]);

        return redirect()->route('sales-pages.show', $salesPage->id);
    }

    public function exportHtml($id)
    {
        $salesPage = SalesPage::where('user_id', Auth::id())->findOrFail($id);
        $content = json_decode($salesPage->generated_content, true) ?: [];

        $formatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        $formattedPrice = $formatter->formatCurrency((float)$salesPage->price, $salesPage->currency);

        // Pastikan variabel 'content' ikut dikirim ke view export
        $htmlContent = view('sales_pages.export', compact('salesPage', 'content', 'formattedPrice'))->render();

        $fileName = Str::slug($salesPage->product_name) . "-sales-page.html";

        return response($htmlContent)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    public function regenerateSection(Request $request, $id)
    {
        $salesPage = SalesPage::where('user_id', Auth::id())->findOrFail($id);
        $section = $request->section; // Contoh: 'headline', 'benefits', atau 'cta'

        // 1. Siapkan Prompt Spesifik
        $prompt = "Based on this product: {$salesPage->product_name}
        Description: {$salesPage->description}
        USP: {$salesPage->unique_selling_points}

        Give me a NEW and BETTER version of the '{$section}' section for a sales page.
        Return ONLY raw JSON with this key:
        { \"{$section}\": ... }";

        // Khusus untuk benefits, ingatkan AI soal jumlahnya
        if ($section == 'benefits') {
            $prompt .= " (Provide EXACTLY 3 points in an array)";
        }

        // 2. Panggil Gemini API
        $url = "https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=" . config('services.gemini.key');
        $response = Http::withoutVerifying()->post($url, [
            'contents' => [['parts' => [['text' => $prompt]]]]
        ]);

        $rawText = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '';
        preg_match('/\{.*\}/s', $rawText, $matches);
        $newPartJson = json_decode($matches[0] ?? '{}', true);

        if (!empty($newPartJson)) {
            // 3. Gabungkan dengan data lama
            $currentData = json_decode($salesPage->generated_content, true);
            $currentData[$section] = $newPartJson[$section]; // Update bagian yang dipilih saja

            $salesPage->update([
                'generated_content' => json_encode($currentData)
            ]);
        }

        return redirect()->back()->with('success', "Section $section updated!");
    }
}