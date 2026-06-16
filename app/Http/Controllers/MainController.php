<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // Data portofolio/kegiatan tiruan (Nanti diambil dari database admin)
        // Mengambil data asli dari database
        $portfolios = \App\Models\Portfolio::latest()->take(3)->get()->toArray();
        $products = \App\Models\Product::latest()->take(3)->get()->toArray();
        return view('index', compact('portfolios', 'products'));
    }
}
