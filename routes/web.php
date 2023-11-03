<?php

use Illuminate\Support\Facades\Route;
use App\Models\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// test many to many relationship
Route::get('/test', function () {
    $profile = Profile::with('sectors')->first();
    $profile->sectors()->attach(3);
    $profile->sectors()->attach(1);
    $profile = Profile::with('sectors')->first();
    dd($profile->toArray());
});
