<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\PackCreationRequest;
use App\Http\Requests\admin\PackImgRequest;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class packController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loadAll(Request $request, int $id_parent)
    {       
        //
       /* $tokenService = Token::getInstance();

        $AuthorisationApp = $request->header()['Authorization'][0];

        if($tokenService->getToken($AuthorisationApp) !== $AuthorisationApp){
            abort(401);
        }*/

        $listPack = DB::table('pack')->get();

        if($id_parent == 1){
              $myParentPacks =  DB::table('pack')
                ->select('pack.id as id_pack')
                ->get();
                
              return response()->json(['listPack' => $listPack, 'myParentPacks'=>$myParentPacks]);
            
        }

        $myParentPacks = DB::table('pack')
                ->join('souscription', 'pack.id', '=', 'souscription.id_pack')
                ->where('souscription.id_user', '=', $id_parent)
                ->select('pack.id as id_pack', 'souscription.id as id_souscription')
                ->get();

        
        return response()->json(['listPack' => $listPack, 'myParentPacks'=>$myParentPacks]);
    }

    public function loadMyPacks(int $id, Request $request){

        $AuthorisationApp = $request->header()['authorization'][0];
      
        if($request->session()->get($AuthorisationApp)!== $AuthorisationApp){
            
        }

        $myPacks = DB::table('pack')
                ->join('souscription', 'pack.id', '=', 'souscription.id_pack')
                ->where('souscription.id_user', '=', $id)
                ->where('souscription.state', '=', 'VALIDE')
                ->select('pack.id as id_pack', 'pack.intitule', 
                         'pack.prix', 'souscription.id as id_souscription',
                         'souscription.approuved_at as dateApprouved', 'souscription.create_at as dateCretaion_pack')
                ->get();
         
        return response()->json(['myPacks' => $myPacks, 'tokenGetting'=> Session::get(sha1($id))]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //create a new type of pack
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackCreationRequest $request)
    {
        //
        $validate = $request->validated();
        $validate['dateCreation'] = date('Y/m/d');
        $response = DB::table('pack')->insert($validate);

        return $response ? json_encode(['done'=> $response ]):json_encode([]);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        return DB::table('pack')->get();
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
    public function update(PackCreationRequest $request)
    {
        //
        $validate = $request->validated();

        $rowsUpdate = DB::table('pack')
                         ->where('id', '=', $request->collect()['id'])
                         ->update($validate);
        return $rowsUpdate > 0 ? json_encode(['updateDone'=>true]):json_encode([]);
    }

    public function updatePp(PackImgRequest $request, string $id){
        $imgBase64 = $request->validated();
        $rowsUpdate = DB::table('pack')->where('id', '=', $id)->update($imgBase64);

        return $rowsUpdate > 0 ? ['updateDone '=> true, 'nbrRows'=> $rowsUpdate]: [];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
