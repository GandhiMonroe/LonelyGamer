<?php

namespace App\Http\Controllers;

use App\Match;
use App\MatchQueue;
use App\Preference;
use http\Exception;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function getAll(Request $request) {
        try {
            $userID = $request->get('userID');
            return response()->json(Match::getAll($userID));
        }
        catch (Exception $e) {
        
        }
    }
    
    public function enterQueue(Request $request) {
        try {
            $userID = $request->get('userID');
            $gameID = $request->get('gameID');
            MatchQueue::EnterQueue($userID, $gameID);
            return response()->json('User now in Queue', 200);
        }
        catch (Exception $e) {
        
        }
    }
    
    public function exitQueue(Request $request) {
        try {
            $userID = $request->get('userID');
            $gameID = $request->get('gameID');
            MatchQueue::ExitQueue($userID, $gameID);
            return response('User has left the queue', 200);
        }
        catch (Exception $e) {
        
        }
    }
    
    public function getList(Request $request) {
        try {
            $userID = $request->get('userID');
            $gameID = $request->get('gameID');
            
            //Get summonerID of user
            $pref = Preference::where('userID', $userID)->where('gameID', $gameID)->first();
            $summonerInfo = json_decode(file_get_contents('https://euw1.api.riotgames.com/lol/summoner/v3/summoners/by-name/'.$pref->account.'?api_key=RGAPI-9a4f59bb-4cf0-4f46-a108-aa5641ebf3ef'), true);
            $summonerID = $summonerInfo->id;
            
            //Get rank info
            $rankInfo = json_decode(file_get_contents('https://euw1.api.riotgames.com/lol/league/v3/positions/by-summoner/'.$summonerID.'?api_key=RGAPI-9a4f59bb-4cf0-4f46-a108-aa5641ebf3ef'), true);
            $rank = $this->convertRank($rankInfo->tier, $rankInfo->rank);
            
            //TODO: Finish this pls ty.
        }
        catch (Exception $e) {
        
        }
    }
    
    public function convertRank($league, $division) {
        $rank = 0;
        
        switch ($league) {
            case 'BRONZE': $rank = 0; break;
            case 'SILVER': $rank = 5; break;
            case 'GOLD': $rank = 10; break;
            case 'PLATINUM': $rank = 15; break;
            case 'DIAMOND': $rank = 20; break;
            case 'MASTER': $rank = 27; break;
            case 'CHALLENGER': $rank = 29; break;
        }
        
        switch ($division) {
            case 'I': $rank += 5; break;
            case 'II': $rank += 4; break;
            case 'III': $rank += 3; break;
            case 'IV': $rank += 2; break;
            case 'V': $rank += 1; break;
        }
        
        return $rank;
    }
}
