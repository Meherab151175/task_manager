<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);
        if ($validateData->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validateData->errors(),
                'message' => 'Provided data is invalid'
            ], 422);
        }

        $user = User::create($validateData->validate());
        $token = $user->createToken($request->name);

        return response()->json([
            'success' => true,
            'data' => $user,
            'token' => $token->plainTextToken,
            'message' => 'User registered successfully'
        ], 201);
    }
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken($user->name);

        return response()->json([
            'success' => true,
            'data' => $user,
            'token' => $token->plainTextToken,
            'message' => 'User logged in successfully'
        ], 200);
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully'
        ], 200);
    }
}
