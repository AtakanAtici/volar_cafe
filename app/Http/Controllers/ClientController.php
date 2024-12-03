<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\Drink;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function selectDealer()
    {
        // Tüm bayileri al
        $dealers = Dealer::all();

        // View'e bayilerle birlikte dön
        return view('client.select-dealer', compact('dealers'));
    }

    public function showProducts($id)
{
    // Şubeye (bayiye) ait ürünleri al
    $products = Product::where('dealer_id', $id)->get();
    $dealer = Dealer::findOrFail($id);
    $drinks = Drink::where('is_active', 1)->get();

    // View'e ürünlerle birlikte dön
    return view('client.products', compact('products', 'dealer', 'drinks'));
}

}
