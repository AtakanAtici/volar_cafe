<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function show()
    {
        $dealerId = Auth::user()->dealer_id;

        // Dealer'a ait siparişleri durum sırasına göre getir (Bekliyor, Onaylandı, Hazır, Teslim Edildi)
        $orders = Order::whereHas('product', function ($query) use ($dealerId) {
            $query->where('dealer_id', $dealerId);
        })
        ->orderByRaw("
            CASE 
                WHEN status = 'bekliyor' THEN 1
                WHEN status = 'onaylandı' THEN 2
                WHEN status = 'hazır' THEN 3
                WHEN status = 'teslim edildi' THEN 4
            END
        ")
        ->get();
    
        return view('admin.dashboard', compact('orders'));
    }

    public function getOrders()
{
    $dealerId = Auth::user()->dealer_id;

    // Dealer'a ait siparişleri duruma göre sırala
    $orders = Order::with('user', 'product', 'drink')->whereHas('product', function ($query) use ($dealerId) {
        $query->where('dealer_id', $dealerId);
    })
    ->orderByRaw("
        CASE 
            WHEN status = 'bekliyor' THEN 1
            WHEN status = 'onaylandı' THEN 2
            WHEN status = 'hazır' THEN 3
            WHEN status = 'teslim edildi' THEN 4
        END
    ")
    ->get();

    return response()->json($orders);
}
}
