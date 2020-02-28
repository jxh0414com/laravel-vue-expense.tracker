<?php

namespace App\Http\Controllers;


use App\Http\Requests\RegisterRequest;
use App\User;

class UserController extends Controller
{
    //
    public function register(RegisterRequest $request) {
        // Incoming validated
        $user = User::_register($request);

        $token = auth()->login($user);

        return response()->json(['token' => $token, 'user' => $user]);
    }
}
