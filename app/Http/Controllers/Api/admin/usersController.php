<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class usersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $userlistSusc = DB::table('souscription')
                        ->join('users', 'users.id', '=' , 'souscription.id_user')
                        ->join('pack', 'pack.id', '=', 'souscription.id_pack')
                        ->where('souscription.state', '=', 'VALIDE')
                        ->select('users.id', 'users.username', 
                                'users.surname', 'users.email', 
                                'users.hasSuscribed',
                                'users.tel', 'souscription.approuved_at', 
                                'users.profilImgUrl',
                                'pack.intitule as pack_intitule',
                                'users.create_at as dateCreation_account',
                                'pack.id as id_pack')
                        ->get();

        $listUser = DB::table('users')
                            ->where('users.hasSuscribed', '=', false)
                            ->select('users.*')
                            ->get();

            return json_encode(['listUserWhoSuscribed'=> $userlistSusc, 'listSimple'=>$listUser]);    
    } 

    public function create()
    {
        //
    }

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
    public function edit(string $id)
    {
        //
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
        
    }
}
