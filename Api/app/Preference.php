<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use http\Exception;

class Preference extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preferences';
    
    public static function insert($preferences){
        try {
        $preference = new Preference();
        
        $users = User::select('id')->where('name', $preferences['userID'])->get();
        
        foreach ($users as $user) {
            $userID = $user->id;
        }
        
        $preference->userID = $userID;
        $preference->gameID = $preferences['gameID'];
        $preference->account = $preferences['account'];
        $preference->myPrimary = $preferences['myPrim'];
        $preference->mySecondary = $preferences['mySec'];
        $preference->matchPrimary = $preferences['matchPrim'];
        $preference->matchSecondary = $preferences['matchSec'];
        $preference->save();
        
        } catch (Exception $e) {
            abort(402, $e->getMessage());
        }
    }
}
