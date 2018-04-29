<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchRequest extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'match_request';
    
    public static function add($userID, $matchID, $gameID) {
        $matchRequest = new MatchRequest();
        $matchRequest->userID = $userID;
        $matchRequest->matchID = $matchID;
        $matchRequest->gameID = $gameID;
        $matchRequest->save();
    }
}
