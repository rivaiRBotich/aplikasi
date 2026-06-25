<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Treatment;
use \App\Models\AccountBank;
class MainController extends Controller
{
    public function index(Request $request)
    {
        // Data portofolio/kegiatan tiruan (Nanti diambil dari database admin)
        // Mengambil data asli dari database
        $portfolios = \App\Models\Portfolio::latest()->paginate(3, ['*'], 'portofolios_page');
        $bank = AccountBank::first();
        // $products = \App\Models\Product::latest()->paginate(3, ['*'], 'products_page');
        // $treatment = \App\Models\Treatment::latest()->take(4)->get()->toArray();
        // $treatment = \App\Models\Treatment::latest()->paginate(3, ['*'], 'treatment_page');
        if ($request->get('show_all_treatments')) {
            $treatment = \App\Models\Treatment::latest()->paginate(999); // semua
            $products = \App\Models\Product::latest()->paginate(999); // semua
        } else {
            $treatment = \App\Models\Treatment::latest()->paginate(3); // default
            $products = \App\Models\Product::latest()->paginate(3);
        }
        
        return view('index', compact('portfolios', 'products','treatment','bank'));
    }
}
