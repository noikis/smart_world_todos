<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        User::create($request->validated());
        $res = [
            'data' => null,
            'message' => "Registered!"
        ];
        return response()->json($res, Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        // if failed authentication
        if(!Auth::attempt($request->validated())) {
            return response()->json(['message' => 'Bad credentials'], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $res = [
            'data' => [
                'access_token' => $user->createToken('access_token')->plainTextToken,
                'refresh_token' => $user->refresh_token
            ],
            'message' => 'Logged!'
        ];
        return response()->json($res, Response::HTTP_CREATED);
    }

    public function refresh(Request $request)
    {
        $user = auth()->user();

        if(!$user->refresh_token === $request['refresh_token'] ) {
            return response()->json(['message' => 'Invalid token'], Response::HTTP_UNAUTHORIZED);
        }
        
        $user->tokens()->delete();
        $res = [
            'data' => [
                'access_token' => $user->createToken('access_token')->plainTextToken,
            ],
            'message' => 'Refreshed!'
        ];
        return response()->json($res);
    }
}
