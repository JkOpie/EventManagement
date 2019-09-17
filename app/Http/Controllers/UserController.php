<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Auth;
use App\User;
use Carbon\Carbon;

class UserController extends Controller
{
  public function __construct()
  {
      $this->middleware(['auth', 'auth.user']);
  }

  public function index()
  {
      $now = Carbon::now();
      $now_formated = $now->isoFormat('YYYY MM DD h:mm:A');
      $event = DB::table('event')
      ->where('event_date', '>=', $now_formated)
      ->get();

      $event_count = DB::table('event')->where('event_date', '>=', $now_formated)->count();
      $user_count =  DB::table('event_runners')
              ->join('event', 'event_runners.event_id', '=', 'event.id')
              ->select('event.*')
              ->where('event_runners.user_id', '=', auth()->user()->id)->count();


      $user = DB::table('event_runners')
      ->where('user_id', '=', auth()->user()->id)
      ->get();

      return view('userdashboard', ['event'=> $event, 'user' => $user, 'event_count' => $event_count, 'user_count' => $user_count]);

  }

  public function get_history(){

    $now = Carbon::now();
    $now_formated = $now->isoFormat('YYYY MM DD h:mm:A');
    $event_count = DB::table('event')->where('event_date', '>=', $now_formated)->count();
    $user_count = DB::table('event_runners')
            ->join('event', 'event_runners.event_id', '=', 'event.id')
            ->select('event.*')
            ->where('event_runners.user_id', '=', auth()->user()->id)->count();

    $history = DB::table('event_runners')
            ->join('event', 'event_runners.event_id', '=', 'event.id')
            ->select('event.*')
            ->where('event_runners.user_id', '=', auth()->user()->id)
            ->get();


    $user = DB::table('event_runners')
    ->where('user_id', '=', auth()->user()->id)
    ->get();

    return view('userprofile.userhistory')
    ->with('history',$history)
    ->with('user', $user)
    ->with('event_count', $event_count)
    ->with('user_count', $user_count);
  }

  public function event_register(request $request){
    $now = Carbon::now();
    $quota =  DB::table('event')->select('quota')->where('id', '=',  $request['id'])->get();
    $count =  DB::table('event_runners')
            ->join('event', 'event_runners.id', '=', 'event.id')
            ->count();

    if ($count <= $quota[0]->quota){
      $save = DB::table('event_runners')->insert([
            'event_id' => $request['id'],
            'user_id'  => $request['user_id'],
            'date_regis' => $now,
          ]);
          if($save){
                  return $this->sendResponse(null, 'Success');
          } else return $this->sendError('delete create unsuccessfully');
    }else {
      return $this->sendError('delete create unsuccessfully');
    }
  }

  public function unregister(request $request){
    $id = $request['id'];

    $delete = DB::table('event_runners')->where('id', '=', $id)->delete();

    if($delete){
            return $this->sendResponse(null, 'Success');
    } else return $this->sendError('delete create unsuccessfully');
  }

   public function showuser()
   {
     $now = Carbon::now();
     $now_formated = $now->isoFormat('YYYY MM DD h:mm:A');
     $event_count = DB::table('event')->where('event_date', '>=', $now_formated)->count();
     $user_count =  DB::table('event_runners')
             ->join('event', 'event_runners.event_id', '=', 'event.id')
             ->select('event.*')
             ->where('event_runners.user_id', '=', auth()->user()->id)->count();
     return view('userprofile.userprofile')
     ->with('event_count',$event_count)
     ->with('user_count',$user_count);
   }

   public function edit($id){

     $now = Carbon::now();
     $now_formated = $now->isoFormat('YYYY MM DD h:mm:A');

     $user = DB::table('users')->find($id);
     $event_count = DB::table('event')->where('event_date', '>=', $now_formated)->count();
     $user_count =  DB::table('event_runners')
             ->join('event', 'event_runners.event_id', '=', 'event.id')
             ->select('event.*')
             ->where('event_runners.user_id', '=', auth()->user()->id)->count();
     return view('userprofile.edit')->with('user',$user)->with('event_count',$event_count)->with('user_count',$user_count);
   }

   public function update(request $request,$id){
     $update = User::where('id', '=', $id)->update([
       //'name' => $request['name'],
       'email' => $request['email'],
       'password' => Hash::make($request['password']),
       'text_pass' => $request['password'] ,
       'phone' => $request['phone'],
       'date_join' => $request['date_join'],
     ]);

     if($update){
         return $this->sendResponse(null, 'Success');
     }else return $this->sendError('error occurrs');
   }

   public function sendError($error, $errorMessages = [], $code = 404)
   {
       $response = [
           'success' => false,
           'message' => $error,
       ];

       if (!empty($errorMessages)) {
           $response['data'] = $errorMessages;
       }
       return response()->json($response, $code);
   }


   public function sendResponse($result, $message)
   {
       $response = [
           'success' => true,
           'data' => $result,
           'message' => $message,
       ];
       return response()->json($response, 200);
   }
}
