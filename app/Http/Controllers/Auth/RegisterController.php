<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'firstName' => ['required','string','max:255'],
            'lastName'  => ['required','string','max:255'],
            'email'     => ['required','email','max:255','unique:users,email'],
            'username'  => ['nullable','string','max:255'],
            'password'  => ['required','string','min:8'],
            'confirmPassword' => ['required','string','min:8'],
            'terms'     => ['accepted'],

            'phone'     => ['nullable','string','max:255'],
            'company'   => ['nullable','string','max:255'],
            'newsletter'=> ['nullable'],
        ]);

        if (($data['password'] ?? null) !== ($data['confirmPassword'] ?? null)) {
            throw ValidationException::withMessages([
                'confirmPassword' => 'Пароли не совпадают',
            ]);
        }

        $fullName = trim(($data['firstName'] ?? '') . ' ' . ($data['lastName'] ?? ''));
        if ($fullName === '') {
            $fullName = (string)($data['username'] ?? 'Пользователь');
        }

        $user = User::create([
            'name' => $fullName,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }
}
