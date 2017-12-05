<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Response;
use http\Exception;
use Illuminate\Http\Request;
use JWTAuth;

class UserController extends Controller
{
    public function register(Request $request){
        $credentials = $request->only('userReg', 'emailReg', 'passReg');
        
        try {
            $user = User::create($credentials);
            //$user = User::where('name','userReg');
        } catch (Exception $e) {
            return response()->json(['error' => 'User already exists.'], Response::HTTP_CONFLICT);
        }
        
        //$token = JWTAuth::fromUser($user);
        
        return response()->json(['message' => 'User registered'], Response::HTTP_OK);
    }
}
