<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\SouscriptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class souscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $id_pack, int $id_user)
    {
        //
        $validate = array();
        $validate['id_user'] = $id_user;
        $validate['id_pack'] = $id_pack;

        $validate['state'] = 'NON_VALIDE';
        $validate['create_at'] = date('Y/m/d');

        $response = DB::table('souscription')->insert($validate);

        return $response ? json_encode(['done'=>$response]):json_encode([]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the my generation by ID resource.
     */

    public function generation(int $id_parent, int $id_pack){
        return json_encode(['firstGeneration'=> $this->getFirstGeneration($id_parent, $id_pack),
                             'secondGeneration'=> $this->getSecondGeneration($id_parent, $id_pack),
                             'thirdGeneration'=> $this->getThirdGeneration($id_parent, $id_pack)
                            ]);
    }

    private function getFirstGeneration(int $id_parent, int $id_pack)
    {
        //
        $response = DB::table('souscription')
                        ->join('pack', 'pack.id', '=', 'souscription.id_pack')
                        ->join('users', 'users.id', '=', 'souscription.id_user')
                        ->where('users.parent_ID', '=', $id_parent)
                        ->where('users.id', '<>', $id_parent)
                        ->where('users.hasSuscribed', '=', true)
                        ->where('pack.id', '=', $id_pack)
                                 
                        ->select(
                                 DB::raw(
                                    'users.id as id_user,
                                    users.username,
                                    users.surname,
                                    users.email as user_email,
                                    souscription.approuved_at as souscription_approuved_at,
                                    souscription.id as id_souscription,
                                    pack.intitule as pack_intitule,
                                    users.profilImgUrl as userProfilImgUrl,
                                    (pack.prix * pack.pourcentage )/100 as gainOnUser'
                                    )    
                                )->get();
        
        return $response;
    }

    private function getThirdGeneration(int $id_parent, int $id_pack)
    {
        //
        $response = DB::table('souscription')
                        ->join('pack', 'pack.id', '=', 'souscription.id_pack')
                        ->join('users', 'users.id', '=', 'souscription.id_user')
                        ->where('users.grandParent2_ID', '=', $id_parent)
                        ->where('users.hasSuscribed', '=', true)
                        ->where('pack.id', '=', $id_pack)
                        ->select(DB::raw(
                                    'users.id as id_user,
                                    users.username,
                                    users.surname, 
                                    users.email as user_email,
                                    souscription.approuved_at as souscription_approuved_at,
                                    souscription.id as id_souscription,
                                    pack.intitule as pack_intitule,
                                    users.profilImgUrl as userProfilImgUrl,
                                    (pack.prix * (pack.pourcentage - (pack.pourcentageReduction*2)))/100 as gainOnUser'
                                                                        )
                                )->get();
        
        return $response;

    }

    private function getSecondGeneration(int $id_parent, int $id_pack)
    {
        //
        $response = DB::table('souscription')
                        ->join('pack', 'pack.id', '=', 'souscription.id_pack')
                        ->join('users', 'users.id', '=', 'souscription.id_user')
                        ->where('users.grandParent1_ID', '=', $id_parent)
                        ->where('users.hasSuscribed', '=', true)
                        ->where('pack.id', '=', $id_pack)
                        ->select(DB::raw(
                                    'users.id as id_user,
                                    users.username,
                                    users.surname, 
                                    users.email as user_email,
                                    souscription.approuved_at as souscription_approuved_at,
                                    souscription.id as id_souscription,
                                    pack.intitule as pack_intitule,
                                    users.profilImgUrl as userProfilImgUrl,
                                    (pack.prix * (pack.pourcentage - pack.pourcentageReduction))/100 as gainOnUser'
                                    )
                                )->get();
        
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
