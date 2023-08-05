<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KelasController;
use App\Http\Controllers\DashboardController;

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


// dashboard
Route::get('/',[DashboardController::class, 'index']);

// kelas
Route::get('kelas',[KelasController::class, 'index']);
Route::get('kelas/create', [KelasController::class, 'create']);
Route::post('kelas',[KelasController::class,'store']);
Route::get('kelas/{id}',[KelasController::class,'show']);
Route::get('kelas/{id}/edit',[KelasController::class,'edit']);
Route::patch('kelas/{id}',[KelasController::class,'update']);