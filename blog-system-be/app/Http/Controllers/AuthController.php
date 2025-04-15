<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function Login(LoginRequest $request){
        $user = auth()->attempt($request->only("email", "password"));
        if (!$user){
            return response()->json([
                "status" => "failed",
                "message" => "account not found."
            ], Response::HTTP_BAD_REQUEST);
        }

        $token = auth()->user()->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], Response::HTTP_OK);
        
    }

    public function Register(RegisterRequest $request){
        User::create([
            "email" => $request->email,
            "password" => bcrypt($request->password),
            "name" => $request->name,
            "role" => "user"
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Created success."
        ]);
    }

    public function Logout(){
        auth()->user()->currentAccessToken()->delete();
        return response()->json(["message" => "Logout."]);
    }
    
}
