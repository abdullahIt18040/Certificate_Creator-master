<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //
    function login(Request $req){

        $user = User::where(['email'=>$req->email])->first();

        if(!$user || !Hash::check($req->password,$user->password)){
            // if no user OR unmatched
            return "Username or pass not matched";

        }else{
            // matched
            $req->session()->put('user',$user);
            return redirect("home");

        }
    }

    function logout(Request $req){
        $req->session()->forget('user');
            return redirect("login");
    }



    function registration(Request $req){


        $user = new User;
        $user->name = $req->user;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->institution = $req->institution;
        $user->password = Hash::make($req->password);


        // event id
        // paid status
        //
        $user->save();

        return redirect('login');

    }

    function index(Request $req){
            return view("index");
    }
}
