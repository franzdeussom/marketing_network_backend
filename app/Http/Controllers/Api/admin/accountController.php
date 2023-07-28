<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\adminGenerateRequest;
use App\Http\Requests\UserAuthRequest;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class accountController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(adminGenerateRequest $request)
    {
        //
        $validate = $request->validated();
        $validate['create_at'] = date('Y/m/d');
        $validate['profilImgUrl'] = null;
        
        $resp = DB::table('admin')
                        ->insert($validate);
        
        return $resp ? json_encode(['isDone'=> $resp]):json_encode([]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(adminGenerateRequest $request)
    {
        //
        $validate = $request->validated();
        $isUpdate = DB::table('admin')
                        ->where('id', '=', $validate['id'])
                        ->update($validate);
        
        return $isUpdate > 0 ? json_encode(['isDone'=> $isUpdate ]):json_encode([]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(UserAuthRequest $request){
        $validateData = $request->validated();
       // $heard = $request->header()["authorization"][0];

        $adminCredential = DB::table('admin')
                                   ->where('email', $validateData['email'])
                                   ->where('password', $validateData['password'])
                                   ->get();

        if(count($adminCredential)>0){
            $tokenService = Token::getInstance();
            $token = $tokenService->generateToken($adminCredential[0]->id);
            $tokenService->addNewToken($adminCredential[0]->id, $token);
   
            $adminCredential[0]->{'token'} = $token; 
            $adminCredential[0]->{'listToken'} = $tokenService->getListToken();

        }
         return $adminCredential;
        }
}
