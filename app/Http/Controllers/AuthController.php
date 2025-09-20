<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // login -> returns token
    public function login(Request $request)
    {

        $data = $request->validate([
            'username'=>'required|string',
            'password'=>'required|string',
        ]);

        $user = User::where('username', $data['username'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message'=>'Invalid credentials'], 401);
        }

        // delete previous tokens (optional)
        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user->only(['id','username','name','role']),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Logged out']);
    }
}
