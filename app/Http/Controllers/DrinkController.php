<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use Illuminate\Http\Request;

class DrinkController extends Controller
{
    function list() {
        $drinks = Drink::get();
        return view('admin.drink.list', compact('drinks'));
    }

    function store(Request $request) {
        Drink::create([
            'id' => Drink::withTrashed()->max('id') +1,
            'name' => $request->name,
            'is_active' => $request->is_active
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'is_active' => 'required|boolean',
    ]);

    $drink = Drink::findOrFail($id);
    $drink->update([
        'name' => $request->name,
        'is_active' => $request->is_active,
    ]);

    return redirect()->back()->with('success', 'İçecek başarıyla güncellendi.');
}

}
