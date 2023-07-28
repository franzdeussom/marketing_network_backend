<?php

use App\Http\Controllers\Api\admin\accountController;
use App\Http\Controllers\Api\admin\formation;
use App\Http\Controllers\Api\admin\packController;
use App\Http\Controllers\Api\admin\souscriptionController;
use App\Http\Controllers\Api\admin\usersController;
use App\Http\Controllers\Api\user\accountController as UserAccountController;
use App\Http\Controllers\Api\user\souscriptionController as UserSouscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('hello', function () {
    return [
            'Success'=>true,
            'Message Addedd' => 'Ajouter avec success'
    ];
});

/*
    ********* Admin Route ************
*/

Route::post('admin/login', [accountController::class, 'login']);

//admin get list of user
Route::get('admin/list/users', [usersController::class, 'index']);

//admin get list of susbc. Request
Route::get('admin/souscription/request', [souscriptionController::class, 'listOfSuscriptionRequest']);

//admin api create new pack and save it
Route::post('admin/create/pack', [packController::class, 'store']);

Route::post('admin/update/pack', [packController::class, 'update']);

Route::get('admin/souscription/approuve/{id_souscription}/{id_user}/{id_admin}', [souscriptionController::class, 'approuveSouscription']);
Route::get('admin/souscription/delete/{id_souscription}', [souscriptionController::class, 'destroy']);
Route::get('admin/packs', [packController::class, 'show']);

Route::post('admin/genenrate/new/admin', [accountController::class, 'create']);
Route::post('admin/account/update', [accountController::class, 'update']);

Route::post('admin/formation', [formation::class, 'store']);
Route::put('admin/formation/{id}', [formation::class, 'update']);
Route::get('admin/formation', [formation::class, 'index']);
Route::put('admin/pack/update/img/{id_img}', [packController::class, 'updatePp']);
/*
    ********* user Route ************
*/

Route::post('user/login', [UserAccountController::class, 'login']);

Route::get('user/mygeneration/{id}', [UserAccountController::class, 'show']);

//save users generate
Route::post('user/generate', [UserAccountController::class , 'generate']);

Route::post('user/update/account', [UserAccountController::class, 'update']);
Route::post("user/update/profile/image", [UserAccountController::class, 'updateImgUrl']);

Route::get('pack/{id_parent}', [packController::class, 'loadAll']);
Route::get('mypack/{id_user}', [packController::class, 'loadMyPacks']);

Route::get('user/formation', [formation::class, 'index']);
Route::get('souscription/request/{id_pack}/{id_user}', [UserSouscriptionController::class, 'create']);

Route::get('user/souscription/generations/{id_parent}/{id_pack}', [UserSouscriptionController::class, 'generation']);


