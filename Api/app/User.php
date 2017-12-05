<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mockery\Exception;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'name', 'email', 'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'password', 'remember_token',
  ];

  public function matches(){
      return $this->belongsToMany('App\Match', 'user_match');
  }
  
  public function chat(){
      return $this->hasMany('App\Chat');
  }
  
  public static function create($credentials){
      try{
          $user = new User();
          $user->name = $credentials['userReg'];
          $user->email = $credentials['emailReg'];
          $user->password = bcrypt($credentials['passReg']);
          $user->save();
          
          //return $this->getJWTIdentifier();
      } catch (Exception $e){
          abort(409, 'User already exists');
          return;
      }
  }
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }
}
