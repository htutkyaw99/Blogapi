<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required|confirmed',
            ]
        );

        $user = User::create($validated);

        $token = $user->createToken($request->name);

        return [
            'message' => 'Registerd successfully!',
            'user' => $user,
            'token' =>  $token->plainTextToken
        ];
    }

    public function login(Request $request)
    {
        $validated = $request->validate(
            [
                'email' => 'required|exists:users,email',
                'password' => 'required',
            ]
        );

        $user = User::where('email', $request->email)->first();

        // return $user;

        if (!$user || !Hash::check($request->password, $user->password)) {
            return [
                'message' => 'Credentials failed'
            ];
        }

        $token = $user->createToken($request->email);

        return [
            'message' => 'Login succesfully!',
            'token' => $token->plainTextToken
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => "Logout successfully!"
        ];
    }
}
