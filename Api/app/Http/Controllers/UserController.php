<?php

namespace App\Http\Controllers;

use App\Match;
use App\MatchHistory;
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
        try {
            $preference = $request->only('userID', 'account', 'gameID', 'myPrim', 'mySec', 'matchPrim', 'matchSec');
    
            Preference::insert($preference);
    
            return response()->json(['message' => 'User preferences created'], Response::HTTP_OK);
            
        } catch (Exception $e) {
            return response()->json(['error' => 'Error adding user preferences'], Response::HTTP_CONFLICT);
        }
    }
    
    public function getRecentGames(Request $request){
        $userID = $request->get('userID');
        $gameID = $request->get('gameID');
    
        $formattedGames = [];
    
        try {
            //Get summonerID of user
            $pref = Preference::where('userID', $userID)->where('gameID', $gameID)->first();
            $account = str_replace(' ', '%20', $pref->account);
            if ($data = @file_get_contents('https://euw1.api.riotgames.com/lol/summoner/v3/summoners/by-name/'.$account.'?api_key=RGAPI-9a4f59bb-4cf0-4f46-a108-aa5641ebf3ef')) {
                $summonerInfo = json_decode($data, true);
                $accountID = $summonerInfo['accountId'];
            } else { throw new \Exception; }
    
            //Get list of champs
            if ($data = @file_get_contents('https://euw1.api.riotgames.com/lol/static-data/v3/champions?locale=en_US&dataById=true&api_key=RGAPI-9a4f59bb-4cf0-4f46-a108-aa5641ebf3ef')) {
                $champs = json_decode($data, true);
                $champs = $champs['data'];
            } else { throw new \Exception; }
    
            //Get last 5 matches
            if ($data = @file_get_contents('https://euw1.api.riotgames.com/lol/match/v3/matchlists/by-account/'.$accountID.'?endIndex=10&queue=420&api_key=RGAPI-9a4f59bb-4cf0-4f46-a108-aa5641ebf3ef')) {
                $gameInfo = json_decode($data, true);
                $gameInfo = $gameInfo['matches'];
            } else { throw new \Exception; }
            
    
            foreach ($gameInfo as $game) {
                $participantID = '';
                // Call API to get each match info including champ
                $gameInfo = json_decode(file_get_contents('https://euw1.api.riotgames.com/lol/match/v3/matches/'. $game['gameId'] .'?api_key=RGAPI-9a4f59bb-4cf0-4f46-a108-aa5641ebf3ef'), true);
                $participantIdentity = $gameInfo['participantIdentities'];
                foreach ($participantIdentity as $identity) {
                    if($identity['player']['accountId'] == $accountID) { $participantID = $identity['participantId']; }
                }
        
                $participants = $gameInfo['participants'];
                foreach ($participants as $part) {
                    if($part['participantId'] == $participantID) {
                        $champ = $part['championId'];
                        $win = $part['stats']['win'];
                        $kills = $part['stats']['kills'];
                        $deaths = $part['stats']['deaths'];
                        $assists = $part['stats']['assists'];
                    }
                }
        
                foreach ($champs as $c) {
                    if ($c['id'] == $champ) {
                        $champ = $c['name'];
                    }
                }
        
                if ($deaths == '0') { $deaths = '1'; }
        
                $kda = round(((int)$kills + (int)$assists) / (int)$deaths, 1);
        
                $new = array('champ' => $champ, 'win' => $win, 'kda' => $kda);
                array_push($formattedGames, $new);
            }
    
            MatchHistory::where('userID', $userID)->delete();
            MatchHistory::addAll($formattedGames, $userID);
        }
        catch (\Exception $e) {
            $matchHistory = MatchHistory::where('userID', $userID)->get();
            
            if ($matchHistory->count()) {
                foreach ($matchHistory as $match) {
                    $new = array('champ' => $match->champ, 'win' => $match->win, 'kda' => $match->kda);
                    array_push($formattedGames, $new);
                }
            }
            else {
                return response()->json(['error' => 'No match history available'], Response::HTTP_BAD_REQUEST);
            }
        }
        
        return response()->json($formattedGames);
    }
}
