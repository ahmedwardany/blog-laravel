<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:subscribers',
            'email' => 'required|string|email|unique:subscribers',
            'password' => 'required|string|min:6',
        ]);

        $subscriber = Subscriber::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'active', 
        ]);
        $token = $subscriber->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }
}
