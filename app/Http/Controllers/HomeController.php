<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home',['posts'=>auth()->user()->posts()->paginate(10),'users' => \App\User::paginate(10)]);
    }

    public function show(\App\User $user){
        return view('users.profile',compact('user'));
    }
}
