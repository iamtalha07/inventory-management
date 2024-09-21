<?php

namespace App\Http\Controllers;

use Session;
use App\User;
use App\ApplicationDetail;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {   
        $users = User::all();
        return view('users.users',['users'=>$users]);
    }

    public function addNewUser()
    {   
        return view('users.user_add');
    }

    public function store(UserRequest $request)
    {   
        $request->merge(['password' => Hash::make($request->password)]);
        $user =  User::create($request->all());
        Session::flash('status','User Added Successfully!');
        return redirect('user');
    }

    public function edit(User $user)
    {   
        return view('users.user_edit',['user'=>$user]);
    }
    
    function update(UserRequest $request,User $user)
    {
        if (!$request->password) {
            unset($request['password']);
        }
        else{
            $request->merge(['password' => Hash::make($request->password)]);
        }
        $user->update($request->all());
        Session::flash('status','User updated successfully');
        return redirect('user');
    }

    public function delete(User $user){
        $user->delete();
        Session::flash('status','User deleted successfully');
        return redirect()->back();
    }

    public function changeProfileForm()
    {
        $user=Auth::user();
        return view('users.user_change_profile',['user'=>$user]);
    }

    function updateUserProfile(UserRequest $request,User $user)
    {
        if (!$request->password) {
            unset($request['password']);
        }
        else{
            $request->merge(['password' => Hash::make($request->password)]);
        }
        $user->update($request->all());
        Session::flash('status','User updated successfully');
        return redirect('user');
    }

    public function updateAppName(Request $request)
    {
        $user = Auth::user();
        $data['application_name']   =  $request->app_name;
      
        if (Hash::check($request->password, $user->password)) {
            // Proceed with updating the application name
            ApplicationDetail::create([
                'modified_by'      => $user->name,
                'application_name' => $request->app_name
            ]);
    
            Session::flash('success','Application name updated successfully');
            return redirect()->back();
        } else {
            Session::flash('error','Invalid credentials');
            return redirect()->back();
        }
    }

    
}
