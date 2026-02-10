<?php

namespace App\Http\Controllers\Professor;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class PasswordController extends Controller
{
    public function edit()
    {
        return view('professor.password.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Senha atual incorreta.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('professor.password.edit')->with('success', 'Senha alterada com sucesso!');
    }
}
