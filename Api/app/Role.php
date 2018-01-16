<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'game_roles';
    
    public static function getRolesForGame($gameID){
        return Role::where('game', $gameID)->get();
    }
}
