<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = Auth::user();

        // Sipariş oluştur
        Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price * $request->quantity,
            'description' => $request->description,
            'drink_id' => $request->drink,
        ]);

        return redirect()->back()->with('success', 'Sipariş başarıyla oluşturuldu.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:bekliyor,onaylandı,hazır,teslim edildi',
        ]);

        // Siparişin durumunu güncelle
        $order->update(['status' => $validated['status']]);

        return response()->json(['success' => true, 'message' => 'Durum başarıyla güncellendi.']);
    }

    function myOrders()
    {
        // Şubeye (bayiye) ait ürünleri al
        $drinks = Drink::where('is_active', 1)->get();
        $products = Order::with('product')->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return view('client.my-orders', compact('products'));
    }


}
