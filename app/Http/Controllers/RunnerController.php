<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\runner;
use App\User;
use App\Role;


class RunnerController extends Controller
{
  public function __construct()
  {
      $this->middleware(['auth','auth.admin']);
  }

  public function index(){


    return view('runner.runners');

  }

  public function create(){
    $event_count = DB::table('event')->count();
    $user_count = DB::table('users')->where('name', '!=', 'Admin')->count();
    return view ('runner.createrunner')->with('event_count',$event_count)->with('user_count', $user_count);
  }

  public function profile_admin($id){
    $admin = User::find($id);
    $event_count = DB::table('event')->count();
    $user_count = DB::table('users')->where('name', '!=', 'Admin')->count();
    return view('runner.admin_edit', compact('admin'))->with('event_count',$event_count)->with('user_count', $user_count);
  }

  public function showrunner(){
    $event_count = DB::table('event')->count();
    $user_count = DB::table('users')->where('name', '!=', 'Admin')->count();
    $runner = DB::table('role_user')
            ->join('users', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->select('users.*')->where('roles.name', '=', 'user')
            ->get();
    return view('runner.runners')->with('runner', $runner)->with('event_count',$event_count)->with('user_count', $user_count);
  }

  public function update_admin (request $request,$id){
    request()->validate([
      'name' => 'required',
      'email' => 'required',
      'password' => 'required|same:con_pass',
      'phone' => 'required',
      'date_join' =>'required',
    ]);

    $update = User::where('id', '=', $id)->update([
      'name' => $request['name'],
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


  public function edit( $id){
    $runner = User::find($id);
    $event_count = DB::table('event')->count();
      $user_count = DB::table('users')->where('name', '!=', 'Admin')->count();
    return view('runner.runner_edit', compact('runner'))->with('event_count',$event_count)->with('user_count', $user_count);
  }
  public function update(request $request,$id){

    request()->validate([
      'name' => 'required',
      'email' => 'required',
      'password' => 'required|same:con_pass',
      'phone' => 'required',
      'date_join' =>'required',
    ]);
  $update = User::where('id', '=', $id)->update([
    'name' => $request['name'],
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

  public function delete(request $request){
    $id = $request['id'];
    $delete = DB::table('users')->where('id','=', $id)->delete();

    if($delete){
            return $this->sendResponse(null, 'Success');
    } else return $this->sendError('delete create unsuccessfully');
  }

  public function store(request $request){
    request()->validate([
      'name' => 'required',
      'email' => 'required',
      'password' => 'required_with:confirmpassword|same:confirmpassword',
      'phone' => 'required',
      'date_join' =>'required',
    ]);

    $same_user = User::where('name', '=', $request['name'])->first();

      if($same_user){
          return $this->sendError('Store unsuccessfully');
      }else {
        $user =  User::create([
          'name' => $request['name'],
          'email' => $request['email'],
          'password' => Hash::make($request['password']),
          'text_pass' => $request['password'] ,
          'phone' => $request['phone'],
          'date_join' => $request['date_join'],
      ]);

      $role = Role::select('id')->where('name', 'user')->first();
      $user->roles()->attach($role);

      return redirect()->route('runner')->with('user', $user);

    }

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
