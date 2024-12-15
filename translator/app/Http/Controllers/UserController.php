<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    public function loginRegisterForm() {
        return view('auth.login-register');
    }

    public function loginRequest(LoginRequest $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('login-register-from')->with('error', 'Email or Password is incorrect!');
        }

        // if (!Hash::check($request->password, $user->password)) {
        //     return redirect()->route('login-register-from')->with('error', 'Email or Password is incorrect!');
        // }

        Auth::login($user, true);

        return redirect()->route('leitner');
    }

    public function registerRequest(RegisterRequest $request) {
        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->username),
        ]);

        Auth::login($user);
        return redirect()->route('leitner');
    }

}
