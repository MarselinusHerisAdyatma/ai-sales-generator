<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesPage;

class SalesPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $salesPages = SalesPage::where('user_id', auth()->id())
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
        $request->validate([
            'product_name' => 'required',
            'description' => 'required',
        ]);

        $featuresArray = array_map('trim', explode(',', $request->features));

        $salesPage = SalesPage::create([
            'user_id' => auth()->id(),
            'product_name' => $request->product_name,
            'description' => $request->description,
            'features' => $request->features,
            'target_audience' => $request->target_audience,
            'price' => $request->price,
            'unique_selling_points' => $request->unique_selling_points,
            'generated_content' => json_encode([
                'headline' => 'Grow Faster with '.$request->product_name,
                'subheadline' => 'Designed for '.$request->target_audience,
                'benefits' => $featuresArray,
                'cta' => 'Enroll Now',
                'social_proof' => 'Trusted by 1,000+ customers'
            ])
        ]);

        return redirect()->route('sales-pages.show', $salesPage->id);
    }

    public function show($id)
    {
        $salesPage = SalesPage::where('user_id', auth()->id())
            ->findOrFail($id);

        $content = json_decode($salesPage->generated_content, true);

        return view('sales_pages.show', compact('salesPage', 'content'));
    }

    public function destroy($id)
    {
        $page = SalesPage::where('user_id', auth()->id())
            ->findOrFail($id);

        $page->delete();

        return redirect()->route('sales-pages.index')
            ->with('success', 'Page deleted.');
    }
}