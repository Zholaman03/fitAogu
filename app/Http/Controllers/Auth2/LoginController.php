<?php

namespace App\Http\Controllers\Auth2;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function login(Request $req){
        if(Auth::check()){
            return redirect()->intended('/posts');
        }
        $validated = $req->validate([
            'email'=>'required|email',
            'password'=>'required|string'

        ]);

        if(Auth::attempt($validated)){
            if(Auth::user()->role->name == "admin"){
                return redirect()->intended('/adm/users');
            }
            return redirect()->intended('/posts');
        }

        return back()->withErrors('Incorrect email or password');
        
    }

    public function logout(){

        Auth::logout();

        return redirect()->route('posts.index');
    }
}
