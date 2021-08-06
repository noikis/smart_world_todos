<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
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
}
