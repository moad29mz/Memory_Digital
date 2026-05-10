<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // تسجيل الدخول
    public function login(Request $request)
    {
        // التحقق من صحة البيانات
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // محاولة تسجيل الدخول
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // إذا فشل تسجيل الدخول
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // إنشاء حساب جديد
    public function register(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // إنشاء المستخدم
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // تسجيل الدخول تلقائياً
        Auth::login($user);

        return redirect('/dashboard');
    }
}