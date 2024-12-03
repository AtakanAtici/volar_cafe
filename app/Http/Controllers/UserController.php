<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function list(Request $request){
        $users = User::with('dealer')
            ->where('is_admin', 1)    
            ->get();

        return view('users.list', compact('users'));
    }

    function create() {
        $dealers = Dealer::get();
        return view('users.create', compact('dealers'));
    }

    function store(Request $request) {
        $request->validate([
            'phone' => 'required|unique:users,phone',
            'name' => 'required',
            'dealer_id' => 'required',
            'password' => 'required|min:3',
        ]);

        try{
            User::create([
                'name' => $request->name,
                'dealer_id' => $request->dealer_id,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'is_admin' => 1,
            ]);    
        }catch(\Exception $e){
            dd($e);
        }
        

        return redirect()->route('users.all');
    }

    function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back();
    }
}
