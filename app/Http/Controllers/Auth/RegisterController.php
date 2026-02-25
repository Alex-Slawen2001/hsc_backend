<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'firstName' => ['required','string','max:255'],
            'lastName' => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email'],
            'phone' => ['required','string','max:50'],
            'username' => ['required','alpha_num','min:4','max:255','unique:users,name'],
            'password' => ['required','string','min:8'],
            'confirmPassword' => ['required','same:password'],
            'terms' => ['accepted'],
        ]);

        $user = User::create([
            'name' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return response()->json(['ok' => true, 'redirect' => url('/dashboard')]);
    }
}
