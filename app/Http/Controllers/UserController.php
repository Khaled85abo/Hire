<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function create(){
        return View('users.register');
    }

    // request as method can be used instead of (Request $request)
    public function store(Request $request){
        // dd($request->name);
        $formsFields= $request->validate([
            'name' => ['required', 'min:3'],
            'email'=> ['required' ,'email', Rule::unique('users','email')],
            'password'=> 'required | confirmed | min:6'
        ]); 

        $formsFields['password']= bcrypt($formsFields['password']);
        $user = User::create($formsFields);
        auth()->login($user);
        return redirect('/')->with('messages', 'User created and logged in');  
    }

    public function login(){
        return View('users.login');
    }

    public function authenticate(Request $request){
        $formsFields  = $request->validate([
            'email'=> ['required', 'email'],
            'password'=> 'required'
        ]);
       if(auth()->attempt($formsFields)){
        $request->session()->regenerate();
        return redirect('/')->with('message', 'Welcome! you are now logged in!');
       }
        return back()->withErrors(['email'=>'Invalid Credentials'])->onlyInput('email'); 
    }

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
       return redirect('/')->with('message', 'You have been logged out');
    }
}
