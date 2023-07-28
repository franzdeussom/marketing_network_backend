<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class authController extends Controller
{
    //
    function login(UserAuthRequest $request){

        $validated = $request->validated();
        $isValid = $request->authorize();
        
        if($isValid){
                $usersCredentials =  DB::table('users')
                ->where('email', $validated['email'])
                ->where('password', $validated['password'])->first();

            return json_encode(['data'=> $usersCredentials]);

        }
 
    return json_encode(['data'=> $validated]);
 }

    function register(){

    }
}