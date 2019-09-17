<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class event extends Model
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'event_name',
    'event_baner',
    'event_des',
    'event_date',
    'start_point',
    'end_point',
    'filename',
    'mime',
    'original_filename',
    'quota',
    'created_at',
    'updated_at',
  ];


}
