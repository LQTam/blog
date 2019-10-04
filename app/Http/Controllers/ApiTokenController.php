<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{
    public function update(Request $req){
        if(auth()->user()){
            $token = Str::random(80);
            $req->user()->forceFill([
                // 'api_token' => hash('sha256',$token),
                'api_token' => $token,
            ])->save();

            return redirect()->back()->with('apiToken',$token);
        }
    }
}
