<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::with('role')->where('status',1)->get()->toArray();
        return view(Auth::user()->role->name,compact('data'));
    }

    public function update(Request $request)
    {
       User::Where('id',$request->id)->update(['first_name'=>$request->first_name,'last_name'=>$request->last_name,'email'=>$request->email,'phone'=>$request->phone]);
       return ['succ'=>true,'msg'=>'Record update successfully'];
    }
}
