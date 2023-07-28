<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\UpdateProfileImgRequest;
use App\Http\Requests\user\UpdateRequest;
use App\Http\Requests\UserAuthRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\Token;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Session;
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

    public function login(UserAuthRequest $userCredentials){
        $validateData = $userCredentials->validated();
        
        $credentials = DB::table('users')
                            ->where('email', '=', $validateData['email'])
                            ->where('password', '=', $validateData['password'])
                            ->get();
                            
        if(count($credentials) > 0){
            $tokenService = Token::getInstance();
            $token = $tokenService->generateToken($credentials[0]->id);
            $tokenService->addNewToken($credentials[0]->id, $token);
            $credentials[0]->{'token'} = $token;
           // $userCredentials->session()->put(['tokk', $token]);
            Session::put(['tok', $token]);
            $credentials[0]->{'token2'} = Session::get('tok');
        }
    
        return $credentials;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function generate(UserRegisterRequest $user)
    {
        //

        $validateData  = $user->validated();
        $validateData['create_at'] = date('Y/m/d');
        $queryResponse = DB::table('users')->insert($validateData);

        return json_encode(['isDone'=> $queryResponse]);
    }

    /**
     * Display the specified resource generation of the current users.
     */
    public function show(int $id)
    {
        //
        return json_encode(['data_store'=>$id]);
    }  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    public function update(UpdateRequest $request)
    {
        //
        $validateData = $request->validated();
        $result = DB::table('users')
                    ->where('id', '=', $validateData['id'])
                    ->update($validateData);
    
        return $result > 0 ? json_encode(['update_Done'=> true]):json_encode(['rsl'=> $result]);
    }


    public function updateImgUrl(UpdateProfileImgRequest $request){
        $data = $request->validated();
        


        $folderPath = public_path() . '/' . 'images/';
        $image_parts = explode(";base64,", $data['profilImgUrl']);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $uniqid = uniqid();

        $file = $folderPath . $uniqid . $data['id'] . '.' . $image_type;
        
        if(file_put_contents($file, $image_base64)){
            $result = DB::table('users')
                        ->where('id', '=', $data['id'])
                        ->update(['profilImgUrl'=> $file ]);

            return json_encode(['isDone'=> $result > 0]);
        }

        return [];
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
