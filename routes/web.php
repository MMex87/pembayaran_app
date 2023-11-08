<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KelasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswaPerKelasController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\NamaTagihanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TagihanPerSiswaController;
use App\Http\Controllers\GolonganController;

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
Route::post('/tahunAjar', [DashboardController::class, 'store']);
Route::Patch('/tahunAjar/{id}', [DashboardController::class, 'update']);
Route::get('/naikKelas', [DashboardController::class, 'naikKelas']);
Route::post('/generateKelas', [DashboardController::class, 'generateKelas']);
Route::post('/generateNaikKelas', [DashboardController::class, 'storeNaikKelas']);

// kelas
Route::get('kelas',[KelasController::class, 'index']);
Route::get('kelas/create', [KelasController::class, 'create']);
Route::post('kelas',[KelasController::class,'store']);
Route::get('kelas/{id}',[KelasController::class,'show']);
Route::get('kelas/{id}/search',[KelasController::class,'search']);
Route::get('kelas/{id}/edit',[KelasController::class,'edit']);
Route::patch('kelas/{id}',[KelasController::class,'update']);
Route::post('kelasValidasi',[KelasController::class,'validation']);

// siswa
Route::get('siswa',[SiswaController::class, 'index']);
Route::get('siswa/create', [SiswaController::class, 'create']);
Route::post('siswa',[SiswaController::class, 'store']);
Route::get('siswa/{id}',[SiswaController::class, 'show']);
Route::patch('siswa/{id}',[SiswaController::class,'update']);
Route::delete('siswa/{id}',[SiswaController::class,'destroy']);
Route::post('siswaImport',[SiswaController::class, 'import']);
Route::patch('siswa/{idSiswa}/{idSPK}',[SiswaController::class, 'updateKelas']);
Route::post('siswaValidasi',[SiswaController::class, 'validation']);

// api get siswa
Route::get('getSiswa',[SiswaPerKelasController::class, 'getSiswa']);

// tagihan
Route::get('tagihan',[TagihanController::class, 'index']);
Route::get('tagihan/create',[TagihanController::class, 'create']);
Route::post('tagihan',[TagihanController::class, 'store']);
Route::get('tagihan/{id}/edit',[TagihanController::class, 'edit']);
Route::patch('tagihan/{id}',[TagihanController::class, 'update']);
Route::patch('tagihan/{id}',[TagihanController::class, 'update']);
Route::post('tagihanValidasi',[TagihanController::class, 'validation']);

// api get siswa
Route::get('getTagihan',[TagihanController::class,'getTagihan']);
Route::get('getTotalTagihan',[TagihanController::class,'getTotalTagihan']);

// nama Tagihan
Route::get('namaTagihan',[NamaTagihanController::class,'index']);
Route::get('namaTagihan/create',[NamaTagihanController::class,'create']);
Route::post('namaTagihan',[NamaTagihanController::class, 'store']);
Route::patch('namaTagihan/{id}',[NamaTagihanController::class, 'update']);
Route::delete('namaTagihan/{id}',[NamaTagihanController::class, 'destroy']);

// nama Golongan
Route::get('golongan',[GolonganController::class,'index']);
Route::get('golongan/create',[GolonganController::class,'create']);
Route::get('getGolongan',[GolonganController::class, 'getGolongan']);
Route::post('golongan',[GolonganController::class, 'store']);
Route::patch('golongan/{id}',[GolonganController::class, 'update']);
Route::delete('golongan/{id}',[GolonganController::class, 'destroy']);
Route::post('golonganValidasi',[GolonganController::class, 'validation']);


// Pembayaran
Route::get('pembayaran',[TransaksiController::class, 'index']);
Route::post('transaksi', [TransaksiController::class, 'store']);
Route::get('print-nota',[TransaksiController::class, 'printNota']);
Route::patch('pembayaran/{id}',[TransaksiController::class, 'update']);
Route::post('transaksiValidasi',[TransaksiController::class, 'validation']);


// Tagihan Per Siswa
Route::get('tagihanPerSiswa', [TagihanPerSiswaController::class, 'index']);