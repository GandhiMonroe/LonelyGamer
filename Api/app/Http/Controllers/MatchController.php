<?php

namespace App\Http\Controllers;

use App\Match;
use App\MatchQueue;
use App\MatchRequest;
use App\Preference;
use App\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MatchController extends Controller
{
    public function getAll(Request $request) {
        try {
            $userID = $request->get('userID');
            
            $matches = Match::getAll($userID);
    
            $matchList = array();
            
            foreach ($matches as $match) {
                $user = User::where('ID', $match->matchUserID)->first();
                
                $array = [
                    'name' => $user->name,
                    'ID' => $match->userID
                ];
                
                array_push($matchList, $array);
            }
            
            return response()->json($matchList);
        }
        catch (Exception $e) {
        
        }
    }
    
    public function enterQueue(Request $request) {
        try {
            $userID = $request->get('userID');
            $gameID = $request->get('gameID');
    
            //Get summonerID of user
            $pref = Preference::where('userID', $userID)->where('gameID', $gameID)->first();
            $account = str_replace(' ', '%20', $pref->account);
            $summonerInfo = json_decode(file_get_contents('https://euw1.api.riotgames.com/lol/summoner/v3/summoners/by-name/'.$account.'?api_key=RGAPI-9a4f59bb-4cf0-4f46-a108-aa5641ebf3ef'), true);
            $summonerID = $summonerInfo['id'];
    
            //Get rank info
            $rankInfo = json_decode(file_get_contents('https://euw1.api.riotgames.com/lol/league/v3/positions/by-summoner/'.$summonerID.'?api_key=RGAPI-9a4f59bb-4cf0-4f46-a108-aa5641ebf3ef'), true);
            $rank = $this->convertRank($rankInfo[0]['tier'], $rankInfo[0]['rank']);
            
            MatchQueue::EnterQueue($userID, $gameID, $rank, $rankInfo[0]['tier'], $rankInfo[0]['rank']);
            return response()->json('User now in Queue', 200);
        }
        catch (Exception $e) {
            return response()->json('User could not enter queue', Response::HTTP_CONFLICT);
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
            
            $rank = MatchQueue::select('rank')->where('userID', $userID)->first();
            $rank = $rank->rank;
            
            $matchList = MatchQueue::where('gameID', $gameID)->where('userID', '!=', $userID)->get();
            
            $finalList = array();
            foreach ($matchList as $entry) {
                if(abs($rank - $entry->rank) < 3) {
                    $user = User::where('id', $entry->userID)->first();
                    $pref = Preference::where('userID', $entry->userID)->first();
                    $array = ['userID' => $entry->userID, 'name' => $user->name, 'tier' => $entry->tier, 'div' => $entry->division,
                              'primary' => $this->convertPosition($pref->myPrimary), 'secondary' => $this->convertPosition($pref->mySecondary)];
                    array_push($finalList, $array);
                }
            }
            
            return response()->json($finalList);
        }
        catch (Exception $e) {
            return response()->json('Could not retrieve list', Response::HTTP_CONFLICT);
        }
    }
    
    public function sendRequest(Request $request) {
        $userID = $request->get('userID');
        $matchID = $request->get('matchID');
        $gameID = $request->get('gameID');
        
        $request = MatchRequest::where('userID', $matchID)->where('matchID', $userID)->where('gameID', $gameID)->get();
        
        if ($request->count()) {
            Match::add($userID, $matchID, $gameID);
    
            MatchRequest::where('userID', $matchID)->where('matchID', $userID)->where('gameID', $gameID)->delete();
            MatchRequest::where('userID', $userID)->where('matchID', $matchID)->where('gameID', $gameID)->delete();
        }
        else {
            MatchRequest::add($userID, $matchID, $gameID);
        }
    }
    
    public function declineRequest(Request $request) {
        try {
            $userID = $request->get('userID');
            $matchID = $request->get('matchID');
            $gameID = $request->get('gameID');
    
            MatchRequest::where('userID', $matchID)->where('matchID', $userID)->where('gameID', $gameID)->delete();
    
            return response()->json('Requests deleted', 200);
        }
        catch (Exception $e) {
            return response()->json('Could not delete requests', Response::HTTP_CONFLICT);
        }
    }
    
    public function unmatch(Request $request) {
        try {
            $userID = $request->get('userID');
            $matchID = $request->get('matchID');
            $gameID = $request->get('gameID');
    
            Match::where('userID', $matchID)->where('matchUserID', $userID)->where('gameID', $gameID)->delete();
            Match::where('userID', $userID)->where('matchUserID', $matchID)->where('gameID', $gameID)->delete();
            
            return response()->json('Unmatched with user '.$matchID, 200);
        }
        catch (Exception $e) {
            return response()->json('Could not unmatch with user '.$matchID, Response::HTTP_CONFLICT);
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
            case 'MASTER': $rank = 27; return $rank; break;
            case 'CHALLENGER': $rank = 29; return $rank; break;
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
    
    public function convertPosition($position) {
        switch ($position) {
            case 1: return 'TOP'; break;
            case 2: return 'JUNGLE'; break;
            case 3: return 'MIDDLE'; break;
            case 4: return 'ADC'; break;
            case 5: return 'SUPPORT'; break;
        }
        
        return 'INVALID';
    }
}
