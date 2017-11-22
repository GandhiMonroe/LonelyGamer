<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'match';
  
  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
  public $timestamps = false;
  
  public function users()
  {
    return $this->belongsToMany('App\User');
  }
}
