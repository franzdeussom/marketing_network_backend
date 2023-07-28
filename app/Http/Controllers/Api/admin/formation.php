<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\FormationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class formation extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         return DB::table('formation_description')->select('*')->get();
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
    public function store(FormationRequest $request)
    {  
        //
        $valited = $request->validated();

        $valited['lastUpdate_Date'] = date('Y/m/d');

        $response = DB::table('formation_description')->insert($valited);
        
        return $response ? json_encode(['data'=> $valited, 'insertDone'=> $response]) : json_encode([]);
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
    public function update(FormationRequest $request, string $id)
    {
        //  
        $validatedState = $request->validated();
        $validatedState['lastUpdate_Date'] = date('Y/m/d');
        $response = DB::table('formation_description')->where('id', '=', $id)
                        ->update($validatedState);
        
        return $response > 0 ? json_encode(['updateDone'=> true, 'dataUpdated'=>$validatedState, 'date'=>date('Y/m/d')]):json_encode([]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
