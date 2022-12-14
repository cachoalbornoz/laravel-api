<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $post_data = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name'     => $post_data['name'],
            'email'    => $post_data['email'],
            'password' => Hash::make($post_data['password']),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->set_response([
                'message' => 'Clave / Password inválidos.',
            ], 'error', 401);
        }

        $user  = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('authToken')->plainTextToken;

        return  $this->set_response([
            'access_token' => $token, 
            'token_type' => 'Bearer'
        ], 'success', 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return ['message' => 'Te has deslogueado'];
    }

    public function profile(Request $request)
    {
        return response()->json([
            'user' => Auth::user(),
        ]);
    }
}
