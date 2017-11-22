<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'chat';
  
  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
  public $timestamps = false;
}
