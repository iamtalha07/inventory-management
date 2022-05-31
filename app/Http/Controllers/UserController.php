<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index()
    {   
        $users = User::all();
        return view('users.users',['users'=>$users]);
    }

    public function addNewUser()
    {   
        // $users = User::all();
        return view('users.user_add');
    }

    
}
