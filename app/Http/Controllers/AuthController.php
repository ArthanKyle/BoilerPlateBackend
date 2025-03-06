<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());

        return response()->json([
            'user' => $user, 
            'message' => 'User registered successfully'
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->validated());

        if (!$token) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'token' => $token, 
            'message' => 'Login successful'
        ], 200);
    }
    
    public function logout(Request $request): JsonResponse
    {
        if (!$request->user()) {
        return response()->json(['message' => 'User not authenticated'], 401);
    }

        $this->authService->logout($request->user());

        return response()->json([
        'message' => 'Logout successful'
    ], 200);
    }


}
