<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'require|confirmed',
            ]
        );

        $user = User::create($validated);

        $token = $request->user()->createToken($request->token_name);

        return [
            'user' => $user,
            'token' => $token->plainText
        ];
    }

    public function login()
    {
        return 'login';
    }

    public function logout()
    {
        return 'logout';
    }
}
