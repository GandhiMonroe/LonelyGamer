<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use http\Exception;

class RoleController extends Controller
{
    public function getAllRolesByGame(Request $request){
        try {
            $gameID = $request->only('gameID');
            return response()->json(Role::getRolesForGame($gameID));
        } catch (Exception $e) {
        
        }
    }
}
