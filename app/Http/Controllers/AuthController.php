<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    function register_show(){
        return view('auth.register');    
    }

    public function register(Request $request)
    {
        // Form verilerini doğrulama
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email',
            'phone' => 'required|string|max:191|unique:users,phone',
            'room_number' => 'required|string|max:191',
            'internel_phone_number' => 'required|string|max:191',
            'password' => 'required|string|min:8',
            'personnel_number' => 'nullable|string|max:191',
        ]);

        // Yeni kullanıcı oluşturma
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'room_number' => $request->input('room_number'),
            'internal_phone' => $request->input('internel_phone_number'),
            'password' => Hash::make($request->input('password')),
            'personnel_number' => $request->input('personnel_number'), // Opsiyonel alan
            'is_admin' => false,
        ]);

        return redirect()->route('login.show')->with('success', 'Hesabınız başarıyla oluşturuldu!');
    }
    
    function login_show(){
        return view('auth.login');    
    }

    function login(Request $request){
                // Doğrulama
                $request->validate([
                    'phone' => 'required|string|max:191',
                    'password' => 'required|string|min:3',
                ]);
        
                // Kullanıcıyı telefon numarası ile bul
                $user = User::where('phone', $request->phone)->first();
        
                // Kullanıcı ve şifre kontrolü
                if ($user && Hash::check($request->password, $user->password)) {
                    // Kullanıcıyı giriş yapmış olarak işaretle
                    Auth::login($user);
        
                    // Başarılı giriş yönlendirmesi
                    if ($user->is_admin) {
                        return redirect()->route('admin.dashboard')->with('success', 'Admin paneline hoş geldiniz.');
                    } else {
                        return redirect()->route('client.select-dealer')->with('success', 'Müşteri paneline hoş geldiniz.');
                    }
                }
        
                // Hatalı giriş mesajı
                return back()->withErrors([
                    'phone' => 'Telefon numarası veya şifre hatalı.',
                ])->withInput();
            }
        
    }
