<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use http\Exception;

class GameController extends Controller
{
    public function getAll(){
        try{
            $games = Game::getAll();
            
            return response()->json($games);
        }
        catch (Exception $e) {
        
        }
        
    }
}
