<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/text', [\App\Http\Controllers\TextController::class, 'getText']);
Route::post('/text', [\App\Http\Controllers\TextController::class, 'postText']);
Route::put('/text', [\App\Http\Controllers\TextController::class, 'putText']);
Route::delete('/text/{id}', [\App\Http\Controllers\TextController::class, 'deleteText']);
