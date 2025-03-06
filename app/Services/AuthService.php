<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function login(array $data)
    {
        if (Auth::attempt($data)) {
            return Auth::user()->createToken('auth_token')->plainTextToken;
        }
        return null;
    }
    public function logout($user)
    {
        if ($user) {
        $user->tokens()->delete(); 
    } else {
        throw new \Exception('User not authenticated');
    }
    }


}
