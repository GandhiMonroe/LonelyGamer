<?php

namespace App;

use http\Exception;
use Illuminate\Database\Eloquent\Model;

class MatchQueue extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'match_queue';
    
    public static function EnterQueue($user, $game) {
        try {
            $userID = User::where('name', $user)->select('id')->first();
            
            $queueEntry = new MatchQueue();
            $queueEntry->userID = $userID->id;
            $queueEntry->gameID = (int)$game;
            $queueEntry->save();
        }
        catch (Exception $e) {
            abort(402, $e->getMessage());
        }
    }
    
    public static function ExitQueue($user, $game) {
        try {
            $userID = User::where('name', $user)->select('id')->first();
            
            MatchQueue::where('userID', $userID->id)->where('gameID', $game)->delete();
        }
        catch (Exception $e) {
            abort(402, $e->getMessage());
        }
    }
}
