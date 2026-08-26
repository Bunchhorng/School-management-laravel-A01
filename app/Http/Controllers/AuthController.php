<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'name'=>'required|string|max:100',
            'email'=>'required|string|email|unique:users,email',
            'password'=>'required|string|max:255'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        return response()->json([
            'message'=>'Registered successfully!',
            'user'=>$user
        ], 201);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message'=>'No credencails'], 401);
        }

        $token = $user->createToken('device-name')->plainTextToken;
        return response()->json([
            'message'=>'Login successfully!',
            'Token'=> $token,
            'user'=>$user
        ], 200);
    }
}
