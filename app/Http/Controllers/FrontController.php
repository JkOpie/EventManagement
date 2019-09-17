<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Carbon\Carbon;

use Auth;

class FrontController extends Controller
{
  public function show_event(){
    $now = Carbon::now();
    $now_formated = $now->isoFormat('YYYY MM DD h:mm:A');
    //$events = DB::table('event')->latest()->get();
    $events_open = DB::table('event')->where('event_date', '>', $now_formated)->get();
    $events_closed = DB::table('event')->where('event_date', '<', $now_formated)->get();

    return view('viewevent')->with('events_open', $events_open)->with('events_closed', $events_closed);
  }

  public function event_list($id){
    $now = Carbon::now();
    $expired = $now->isoFormat('YYYY MM DD h:mm:A');

    if(Auth::user())
      {
          $user_id = auth()->user()->id;

          $user = DB::table('event_runners')
          ->where('user_id', '=', $user_id)
          ->where('event_id', '=', $id)
          ->first();

          $event = DB::table('event')->find($id);
          return view('eventbyid')->with('event', $event)->with('expired',$expired)->with('user',$user);
      }

      if(Auth::guest())
      {

        $event = DB::table('event')->find($id);
        return view('eventbyid')->with('event', $event)->with('expired',$expired);
      }

  }
}
