<?php

use App\Http\Controllers\ProfileController;
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

// THIS IS JUST A TEST
Route::get('/test', function(Request $request){
    return 'Success';   
});
Route::get('getProfiles', [ProfileController::class, 'getProfiles']);

// THIS IS THE ACTUAL TASK
Route::get('citizen/get/one/{pin}', [ProfileController::class, 'getOneCitizen']);
Route::get('citizen/get/one/{id}', [ProfileController::class, 'getOneCitizen']);
Route::post('citizen/store', [ProfileController::class, 'addProfile']);
Route::post('citizen/store', [ProfileController::class, 'addCitizen']);
Route::put('citizen/update/{id}', [ProfileController::class, 'updateCitizen']);
<<<<<<< HEAD
Route::delete('citizen/delete/{id}', [ProfileController::class, 'deleteCitizen']);
=======
Route::delete('citizen/delete/{id}', [ProfileController::class, 'deleteCitizen']);
>>>>>>> 622f352ab3370715678069aef31c980f3053a057
