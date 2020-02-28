<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login']);
    }

    public function login(LoginRequest $request) {
        // Incoming data is validated....
        $data = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($data)) {
            return response()->json(['errors' => ['error' => 'Invalid credentials']]);
        }

        return response()->json(['token' => $token]);
    }

    public function loadUser() {
        $user = auth()->user();

        return response()->json(['user' => $user]);
    }

    public function logout() {
        auth()->logout();
    }
}
