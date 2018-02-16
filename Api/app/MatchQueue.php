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
    
    public static function EnterQueue($user, $game, $rank) {
        try {
            $queueEntry = new MatchQueue();
            $queueEntry->userID = $user;
            $queueEntry->gameID = (int)$game;
            $queueEntry->rank = (int)$rank;
            $queueEntry->save();
        }
        catch (Exception $e) {
            abort(402, $e->getMessage());
        }
    }
    
    public static function ExitQueue($user, $game) {
        try {
            MatchQueue::where('userID', $user)->where('gameID', $game)->delete();
        }
        catch (Exception $e) {
            abort(402, $e->getMessage());
        }
    }
}
