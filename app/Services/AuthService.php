<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function attemptLogin(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function apiLogin(string $username, string $password): ?array
    {
        $user = User::where('username',$username)->first();
        if(!$user || !Hash::check($password,$user->password)){
            return null;
        }
        $token = $user->createToken('api-token')->plainTextToken;
        return [
            'token'=>$token,
            'user'=>$user->only(['id','username','name','role']),
        ];
    }
}
