<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'masp' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(['masp' => $credentials['masp'], 'password' => $credentials['password']], true)) {
            $request->session()->regenerate();

            return Auth::user()->is_admin
                ? redirect()->route('admin.home')
                : redirect()->route('professor.home');
        }

        return back()->withErrors([
            'masp' => 'MASP ou senha inválidos.',
        ])->onlyInput('masp');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
