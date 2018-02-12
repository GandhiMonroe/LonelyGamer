<?php

namespace App\Http\Controllers;

use App\Preference;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use http\Exception;
use Illuminate\Http\Request;
use JWTAuth;

class UserController extends Controller
{
    public function register(Request $request){
        $credentials = $request->only('userReg', 'emailReg', 'passReg');
        
        try {
            User::create($credentials);
            //$user = User::where('name','userReg');
        } catch (Exception $e) {
            return response()->json(['error' => 'User already exists.'], Response::HTTP_CONFLICT);
        }
        
        $user = User::where('name', $credentials['userReg'])->first();
    
        $code = str_random(10);
        return response()->json(['message' => 'User registered', 'user' => $user->name, 'token' => $code, 'userID' => $user->id], Response::HTTP_OK);
    }
    
    public function signin(Request $request){
        $credentials = $request->only('user', 'pass');
        
        try{
            if(User::check($credentials)){
                $user = User::where('name', $credentials['user'])->first();
                $code = str_random(10);
                return response()->json(['message' => 'Login successful', 'user' => $user->name, 'token' => $code, 'userID' => $user->id], Response::HTTP_OK);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'User does not exist'], Response::HTTP_UNAUTHORIZED);
        }
    }
    
    public function insertPref(Request $request){
        $preference = $request->only('userID', 'account', 'gameID', 'myPrim', 'mySec', 'matchPrim', 'matchSec');
        
        Preference::insert($preference);
        
        return Response::HTTP_OK;
    }
}
