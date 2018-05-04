<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'match_history';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    
    public static function addAll($data, $userID){
        foreach ($data as $item) {
            $newHist = new MatchHistory();
            $newHist->userID = $userID;
            $newHist->champ = $item['champ'];
            $newHist->win = $item['win'];
            $newHist->kda = $item['kda'];
            $newHist->save();
        }
    }
}
