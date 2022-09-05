<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function create()
    {
        return View('users.register');
    }

    // request as method can be used instead of (Request $request)
    public function store(Request $request)
    {
        // dd($request);
        $formsFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required | confirmed | min:6'
        ]);

        if ($request->has('role')) {
            //Checkbox checked
            $formsFields['role'] = 'developer';
        } else {
            //Checkbox not checked
            $formsFields['role'] = null;
        }
        $formsFields['password'] = bcrypt($formsFields['password']);
        $user = User::create($formsFields);
        auth()->login($user);
        return redirect('/')->with('messages', 'User created and logged in');
    }

    public function login()
    {
        return View('users.login');
    }

    public function authenticate(Request $request)
    {
        $formsFields  = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);
        if (auth()->attempt($formsFields)) {
            $request->session()->regenerate();
            $message = 'Welcome! you are now logged in!';

            if (auth()->user()->role == null) {
                return redirect('/profiles')->with('message', $message);
            }
            return redirect('/')->with('message', $message);
        }
        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', 'You have been logged out');
    }
}
