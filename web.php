<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasantriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengarangController;
use App\Http\Controllers\pegawaicontroller;
use App\Http\Controllers\penerbitcontroller;
use App\Http\Controllers\Kategoricontroller;
use App\Http\Controllers\Bukucontroller;
use App\Http\Controllers\DataMahasantricontroller;

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

//Url Salam
Route::get('/salam',function(){
    return "Assalamu'alaikum Selamat Pagi Dunia";
});

// Route dengan Parameter
Route::get('/pegawai/{nama}/{divisi}',function($nama,$divisi){
    return "Nama Pegawai : ".$nama."<br/>Departemen : ".$divisi;
});

// Route dengan Redirect Page Views
Route::get('/kabar', function () {
    return view('latihan.kondisi');
}); 

// Route /mahasantri
Route::get('/mahasantri',[MahasantriController::class, 'dataMahasantri']);

Route::get ('/hello', function (){
    return view('hello', ['name' => 'inaya']);
});

//route nilai
Route::get ('/nilai', function (){
    return view('latihan.nilai');
});

//route daftar nilai
Route::get ('/daftarnilai', function (){
    return view('latihan.daftar_nilai');
});

//route Framework
Route::get ('/phpframework', function (){
    return view('layouts.index');
});

Route::get('/home', [HomeController::class, 'index']);
Route::get('/aboutus', [HomeController::class, 'aboutus']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/pegawai', [PegawaiController::class, 'index']);
Route::resource('pegawai', pegawaicontroller::class);

//
Route::resource('pengarang', PengarangController::class);
Route::resource('penerbit', PenerbitController::class);
Route::resource('kategori', KategoriController::class);
Route::resource('buku', BukuController::class);
Route::get('bukupdf', [BukuController::class,'bukuPDF']);
Route::get('bukucsv',[BukuController::class,'bukucsv']);



//uts
Route::resource('datamahasantri', DataMahasantriController::class);
Route::get('/jurusan',[DataMahasantriController::class, 'jurusan']);


// Form Data Pegawai
Route::get('/formPegawai',[pegawaicontroller::class, 'create']);
Route::post('/formPegawai',[pegawaicontroller::class, 'store'])->name('pegawai.store');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

