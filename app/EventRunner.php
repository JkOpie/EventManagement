<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EventRunner extends Model
{
      use Notifiable;

      protected $fillable = [
          'event_id','user_id',
      ];
}
