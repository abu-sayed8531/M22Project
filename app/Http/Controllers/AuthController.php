<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('login');
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
            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'email' => "The provided credential do not match our records",
        ])->onlyInput('email');
    }
    public function register()
    {
        return view('register');
    }
    public function store(Request $request)
    {

        $data = $request->validateWithBag('register', [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed'
        ]);
        $userData = $request->only(['name', 'email', 'password']);
        $user =  User::create($userData);
        Auth::login($user, true);
        return redirect('/dashboard');
    }
    public function index()
    {
        // dd([
        //     'session_token' => session()->token(),
        //     'csrf_token_func' => csrf_token(),
        //     'xsrf_cookie' => request()->cookie('XSRF-TOKEN'),
        // ]);

        return view('dashboard');
    }
}
