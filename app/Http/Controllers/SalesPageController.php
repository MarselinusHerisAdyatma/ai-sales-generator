<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesPage;
use Illuminate\Support\Facades\Auth;

class SalesPageController extends Controller
{
    public function __construct()
    {
        // 🔒 WAJIB LOGIN untuk semua method
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();

        $salesPages = SalesPage::where('user_id', $userId)
            ->latest()
            ->get();

        return view('sales_pages.index', compact('salesPages'));
    }

    public function create()
    {
        return view('sales_pages.create');
    }

    public function store(Request $request)
    {
        // 🔒 VALIDASI LEBIH AMAN
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'nullable|string',
            'target_audience' => 'nullable|string',
            'price' => 'nullable|string',
            'unique_selling_points' => 'nullable|string',
        ]);

        // 🔒 SAFE EXPLODE (anti error kalau kosong)
        $featuresArray = $request->features
            ? array_map('trim', explode(',', $request->features))
            : [];

        $salesPage = SalesPage::create([
            'user_id' => Auth::id(),
            'product_name' => $request->product_name,
            'description' => $request->description,
            'features' => $request->features,
            'target_audience' => $request->target_audience,
            'price' => $request->price,
            'unique_selling_points' => $request->unique_selling_points,

            'generated_content' => json_encode([
                'headline' => 'Grow Faster with ' . $request->product_name,

                'subheadline' =>
                    'Designed for ' . ($request->target_audience ?? 'everyone') .
                    ' who want faster results.',

                'benefits' => $featuresArray,

                'cta' => 'Enroll Now',

                'social_proof' => 'Trusted by 1,000+ happy customers'
            ])
        ]);

        return redirect()->route('sales-pages.show', $salesPage->id);
    }

    public function show($id)
    {
        $salesPage = SalesPage::where('user_id', Auth::id())
            ->findOrFail($id);

        $content = json_decode($salesPage->generated_content, true);

        return view('sales_pages.show', compact('salesPage', 'content'));
    }

    public function destroy($id)
    {
        $page = SalesPage::where('user_id', Auth::id())
            ->findOrFail($id);

        $page->delete();

        return redirect()
            ->route('sales-pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}