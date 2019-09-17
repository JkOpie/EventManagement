<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\event;
use Carbon\Carbon;

class EventController extends Controller
{
  public function __construct()
  {
      $this->middleware(['auth','auth.admin']);
  }

  public function index()
  {
    $event = DB::table('event')->latest()->get();
    $event_count = DB::table('event')->count();
    $user_count = DB::table('users')->where('name', '!=', 'Admin')->count();

    return view('event.events')
    ->with('event', $event )
    ->with('event_count',$event_count)
    ->with('user_count', $user_count);
  }

  public function show_event_runner(request $request, $event_id){

    $runner = DB::table('event_runners')
            ->join('users', 'event_runners.user_id', '=', 'users.id')
            ->join('event', 'event_runners.event_id', '=', 'event.id')
            ->select('users.id','users.name','users.email','users.phone','users.date_join','event_runners.date_regis')
            ->where('event_runners.event_id', '=',  $request['event_id'])
            ->get();

    if ($runner) {
            return $this->sendResponse($runner, 'Success');
        } else return $this->sendError('show event runner unsuccessfully');
  }


  public function register(){
    $event_count = DB::table('event')->count();
      $user_count = DB::table('users')->where('name', '!=', 'Admin')->count();
    return view('event.register_event')
    ->with('event_count',$event_count)
    ->with('user_count', $user_count);

  }

  public function create(request $request){

    $cover = $request->file('file_banner');
    $extension = $cover->getClientOriginalExtension();
    Storage::disk('public')->put($cover->getFilename().'.'.$extension,  File::get($cover));
    $now = Carbon::now();

    $event =  DB::table('event')->insert([
      'event_name' => $request['event_title'],
      'event_des' => $request['desc_event'],
      'event_date' => $request['date_event'],
      'start_point' => $request['start'],
      'end_point' => $request['end'],
      'mime' => $cover->getClientMimeType(),
      'original_filename' => $cover->getClientOriginalName(),
      'filename' => $cover->getFilename().'.'.$extension,
      'quota' =>  $request['quota'],
      'created_at' => $now,
      'updated_at' => $now,
    ]);

    if ($event) {
              return $this->sendResponse(null, 'Success');
        } else return $this->sendError('event create unsuccessfully');

  }

  public function delete(request $request){

    $id = $request['id'];
    $delete = DB::table('event')->where('id','=', $id)->delete();
    $event_delete =  DB::table('event_runners')->where('event_id', '=', $id)->delete();

    if($delete){
            return $this->sendResponse(null, 'Success');
    } else return $this->sendError('delete create unsuccessfully');

  }

  public function edit($id){
      $event = DB::table('event')->find($id);
      $event_count = DB::table('event')->count();
      $user_count = DB::table('users')->where('name', '!=', 'Admin')->count();
      return view('event.event_edit')->with('event', $event)->with('event_count',$event_count)->with('user_count', $user_count);;
  }

  public function update(request $request){
    $id = $request['event_id'];

    if( $request->hasFile('file_banner') == null){
      $update = DB::table('event')->where('id', '=',  $id)
      ->update([
      'event_name'=> $request['event_title'],
      'event_des'=> $request['desc_event'],
      'event_date' => $request['date_event'],
      'start_point' => $request['start'],
      'end_point' => $request['end'],
      'quota' => $request['quota'],
      ]);
    }

    if ($request->hasFile('file_banner')) {
      $cover = $request->file('file_banner');
       $extension = $cover->getClientOriginalExtension();
      Storage::disk('public')->put($cover->getFilename().'.'.$extension,  File::get($cover));

      $update = DB::table('event')->where('id', '=',  $id)
      ->update([
      'event_name'=> $request['event_title'],
      'event_des'=> $request['desc_event'],
      'event_date' => $request['date_event'],
      'start_point' => $request['start'],
      'end_point' => $request['end'],
      'mime' => $cover->getClientMimeType(),
      'original_filename' => $cover->getClientOriginalName(),
      'filename' => $cover->getFilename().'.'.$extension,
      'quota' => $request['quota'],
      ]);
    }

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


  public function sendResponse($result , $message)
  {
      $response = [
          'success' => true,
          'data' => $result,
          'message' => $message,
      ];
      return response()->json($response, 200);
  }
}
