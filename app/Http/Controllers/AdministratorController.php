<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Illuminate\Http\Request;
use Auth;

class AdministratorController extends Controller
{
    public function loginView(){
        return view('login');
    }

    public function login(){
        $credentials=$this->validate(request(),
        ['email'=>'email|required|string',
        'password'=>'required|string']);

        if (Auth::guard('web')->attempt($credentials)){ 
            return redirect(route('dashboard'));
        }
        return back()
        ->withErrors(['email'=>'Estas credenciales no concuerdan con nuestros registros.'])
        ->withInput(request(['email']));
    }

    public function logout(){
        Auth::guard('web')->logout();
        return redirect(route('login.view'));
    }

    public function dashboard(){
        return view('dashboard');
    }

}
