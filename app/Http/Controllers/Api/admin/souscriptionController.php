<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\enum\STATEMENT;


class souscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function listOfSuscriptionRequest(){
         $list = DB::table('souscription')
                        ->join('users', 'souscription.id_user', '=', 'users.id')
                        ->join('pack', 'souscription.id_pack', '=', 'pack.id')
                        ->where('souscription.state', '=', 'NON_VALIDE')
                        ->select('souscription.id', 
                                'souscription.create_at', 
                                'users.id as id_user', 
                                'users.username', 
                                'users.surname',
                                'users.profilImgUrl', 
                                'users.tel', 
                                'pack.id as id_pack',
                                'pack.intitule',
                                'pack.prix', 
                                'pack.pourcentage')
                        ->get();

        return $list;
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function approuveSouscription(int $id_souscription, int $id_user, int $id_admin)
    {   
        //
        $validate = array();

        $validate['id_admin'] = $id_admin;
        $validate['approuved_at'] = date('Y/m/d');
        $validate['state'] = 'VALIDE';

        $response = DB::table('souscription')
                        ->where('id', '=', $id_souscription)
                        ->update($validate);
        if($response){
            $updateAccount = DB::table('users')
                                ->where('id', '=', $id_user)
                                ->update(['hasSuscribed'=> true]);
        }

        return ($response && $updateAccount)? json_encode(['done' => $response ]):json_encode([]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
        $done = DB::table('souscription')
                        ->where('id', '=', $id)
                        ->delete();
        return $done > 0 ? json_encode(['done'=> true]):json_encode([]);
    }
}
