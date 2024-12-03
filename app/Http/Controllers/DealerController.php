<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    public function list()
    {
        // Tüm bayileri veritabanından al
        $dealers = Dealer::all();

        // Bayileri view'e gönder
        return view('admin.dealer.list', compact('dealers'));
    }

    public function showProducts($id)
    {
        // Bayiyi ve ürünlerini al
        $dealer = Dealer::with('products')->findOrFail($id);

        // View'e bayi ve ürünleri gönder
        return view('admin.product.list', compact('dealer'));
    }
}
