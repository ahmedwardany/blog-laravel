<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        if (Auth::guard('subscribers')->attempt($request->only('email', 'password'))) {
            $subscriber = Auth::guard('subscribers')->user();
    
            if (!$subscriber->device_id) {

                $subscriber->device_id = $request->device_id;
                $subscriber->save();

            } elseif ($subscriber->device_id !== $request->device_id) {
                
                Auth::guard('subscribers')->logout();
                throw ValidationException::withMessages([
                    'email' => ['You are logged in from another device.'],
                ]);
            }
    
            $token = $subscriber->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        }
    
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
