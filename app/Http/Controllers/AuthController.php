<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        $remember_me = $request->remember_me ? true : false;

        if (Auth::guard('web')->attempt($validated, $remember_me)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }
        return back()->withErrors([
            'email' => "The provided credential do not match our records",
        ])->onlyInput('email');
    }
    public function registerPage()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {

        $data = $request->validateWithBag('register', [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed'
        ]);
        $userData = $request->only(['name', 'email', 'password']);
        $user =  User::create($userData);
        Auth::login($user, true);
        return redirect('admin/dashboard');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerate();
        $request->session()->regenerateToken();
        return redirect()->route('login.page');
    }
}
