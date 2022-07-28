<?php

namespace App\Http\Controllers\Auth\Register;

use App\Models\Users\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:30|string',
            'email' => 'required|max:100|email|unique:users',
            'password' => 'required|min:8|max:30|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    // public function registerForm(){
    //     return view("auth.register");
    // }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();

            $validator = $this->validator($data);
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $this->create($data);
                return redirect('added');
            }
        }
        return view('auth.register');
    }

    public function added()
    {
        return view('auth.added');
    }
}
