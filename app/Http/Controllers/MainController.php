<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // Data portofolio/kegiatan tiruan (Nanti diambil dari database admin)
        // Mengambil data asli dari database
        $portfolios = \App\Models\Portfolio::latest()->paginate(3, ['*'], 'portofolios_page');
        $products = \App\Models\Product::latest()->paginate(3, ['*'], 'products_page');
        // $treatment = \App\Models\Treatment::latest()->take(4)->get()->toArray();
        $treatment = \App\Models\Treatment::latest()->paginate(3, ['*'], 'treatment_page');

        return view('index', compact('portfolios', 'products','treatment'));
    }
}
