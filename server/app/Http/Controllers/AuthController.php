<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register (Request $request)
    {

    }

    /*
     * User auth with return token.
     */
    public function login (Request $request)
    {
        $validData = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
            'email' => 'required|string|email',
        ]);

        // Return response if validate failed.
        if (isset($validData['errors']) && count($validData['errors']) > 0)
        {
            return response($validData, 422);
        }

        // Get user with same email from request.
        $user = User::all()->where('email', '=', $validData['email'])->first();
        if ($user)
        {
            // Password check.
            if (!Hash::check($validData['password'], $user->password))
                return response(['message' => 'Password is incorrect'], 422);

            // Create token and return response 200.
            $token = $user->createToken('Todos Password Grant Client')->accessToken;
            return response(['token' => $token], 200);
        }

        // Can't find a user with the email.
        return response(['message' => 'User does not exist'], 404);
    }

    public function logout (Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return response(['message' => 'You have been successfully logged out']);
    }

    public function handleAccess (Request $request)
    {
        return response(['message' => 'You have authorize first'], 401);
    }
}
