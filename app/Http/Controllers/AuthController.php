<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle the registration of a new user.
     *
     * @param Request $request
     */

    public function register(Request $request)
    {
        // Validate the request data.
        $validatedData = $request->validate([
            'name' => 'required|string|max:256',
            'email' => 'required|string|email|max:256|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'in:admin,user'
        ]);

        // Check if the user already exists.
        if (User::where('email', $validatedData['email'])->exists()) {
            return response()->json(['message' => 'User already exists'], 409);
        }

        // Create the user.
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Create the access token for the user.
        $token = $user->createToken($user->email, ['user:read'])->accessToken;

        // Return a success response.
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(Request $request)
    {
        // Validate the request data.
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user.
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // If authentication is successful, get the authenticated user.
        $user = Auth::user();

        // Create the access token for the authenticated user.
        if ($user->role === 'admin') {
            $token = $user->createToken($user->email, ['user:all'])->accessToken;
        }
        else {
            $token = $user->createToken($user->email, ['user:read'])->accessToken;
        }

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }
}