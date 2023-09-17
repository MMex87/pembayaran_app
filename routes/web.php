<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KelasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswaPerKelasController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\NamaTagihanController;
use App\Http\Controllers\TransaksiController;

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

// siswa
Route::get('siswa',[SiswaController::class, 'index']);
Route::get('siswa/create', [SiswaController::class, 'create']);
Route::post('siswa',[SiswaController::class, 'store']);
Route::get('siswa/{id}',[SiswaController::class, 'show']);
Route::patch('siswa/{id}',[SiswaController::class,'update']);
Route::delete('siswa/{id}',[SiswaController::class,'destroy']);
Route::post('siswaImport',[SiswaController::class, 'import']);
// api get siswa
Route::get('getSiswa',[SiswaPerKelasController::class, 'getSiswa']);

// tagihan
Route::get('tagihan',[TagihanController::class, 'index']);
Route::get('tagihan/create',[TagihanController::class, 'create']);
Route::post('tagihan',[TagihanController::class, 'store']);
Route::get('tagihan/{id}/edit',[TagihanController::class, 'edit']);
Route::patch('tagihan/{id}',[TagihanController::class, 'update']);

// api get siswa
Route::get('getTagihan',[TagihanController::class,'getTagihan']);
Route::get('getTotalTagihan',[TagihanController::class,'getTotalTagihan']);

// nama Tagihan
Route::get('namaTagihan',[NamaTagihanController::class,'index']);
Route::get('namaTagihan/create',[NamaTagihanController::class,'create']);
Route::post('namaTagihan',[NamaTagihanController::class, 'store']);
Route::patch('namaTagihan/{id}',[NamaTagihanController::class, 'update']);
Route::delete('namaTagihan/{id}',[NamaTagihanController::class, 'destroy']);


// Pembayaran
Route::get('pembayaran',[TransaksiController::class, 'index']);
Route::post('transaksi', [TransaksiController::class, 'store']);