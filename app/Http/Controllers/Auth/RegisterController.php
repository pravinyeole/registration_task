<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Mail;
use App\Mail\verifyemail;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|min:11|numeric',            
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
        Session::flash('status','Registered! but verify your email to activate your account');

        $record = User::get()->toArray();


        if(count($record) ==  0)
        {
            $role = 1;
        }
        else
        {
            $role = 2;
        }


        $user =  User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'role_id' => $role,
            'verify_token'=> Str::random(40),
        ]);

        $thisuser = User::findOrFail($user->id);
        $this->send_email($thisuser);
        return $user;
    }

    public function send_email($thisuser)
    {
        Mail::to($thisuser['email'])->send(new verifyemail($thisuser));
    }

    public function verify_email()
    {
        return view('verify_email');
    }

    public function send_email_done($email,$verify_token)
    {
        $user = User::where(['email'=>$email,'verify_token'=>$verify_token])->first();

        if($user)
        {
            User::where(['email'=>$email,'verify_token'=>$verify_token])->update(['status'=>1,'verify_token'=>NULL]);
            return "Verification successfully";            
        } 
        else
        {
            return "User not found";
        }
    }
}
