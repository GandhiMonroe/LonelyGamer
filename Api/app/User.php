<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
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
      'remember_token'
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
      } catch (Exception $e){
          abort(409, 'User already exists');
          return;
      }
  }
  
  public static function check($credentials){
      $strUser = (string)$credentials['user'];
      $strPass = (string)$credentials['pass'];
      
      $user = User::where('name', $strUser)->first();
      
      if ($user) {
          if (!Hash::check($strPass, $user->password)){
              abort(409, 'User doesnt exists');
              return false;
          }
      }
      else
      {
          abort(409, 'User doesnt exists');
          return false;
      }
      
      return true;
  }
}
