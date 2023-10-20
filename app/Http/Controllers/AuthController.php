<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function index(Request $request)
  {
    if ($request->session()->has('user')) {
      return redirect('/dashboard');
    }
    return view('login');
  }
  public function authenticate(Request $request)
  {
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      $user = Auth::user();
      session(['user' => $user]);
      return redirect()->intended('/dashboard');
    }

    return redirect('/login')->withErrors(['Username atau password salah']);
  }
  public function logout(Request $request)
  {
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
  }
}
