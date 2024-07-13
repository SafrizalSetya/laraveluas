<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PerhitunganController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

// Routes for Kriteria
Route::get('kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
Route::get('kriteria/create', [KriteriaController::class, 'create'])->name('kriteria.create');
Route::post('kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
Route::get('kriteria/{id}', [KriteriaController::class, 'show'])->name('kriteria.show');
Route::get('kriteria/{id}/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
Route::put('kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
Route::delete('kriteria/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');

// Routes for Alternatif
Route::get('alternatif', [AlternatifController::class, 'index'])->name('alternatif.index');
Route::get('alternatif/create', [AlternatifController::class, 'create'])->name('alternatif.create');
Route::post('alternatif', [AlternatifController::class, 'store'])->name('alternatif.store');
Route::get('alternatif/{alternatif}', [AlternatifController::class, 'show'])->name('alternatif.show');
Route::get('alternatif/{alternatif}/edit', [AlternatifController::class, 'edit'])->name('alternatif.edit');
Route::put('alternatif/{alternatif}', [AlternatifController::class, 'update'])->name('alternatif.update');
Route::delete('alternatif/{alternatif}', [AlternatifController::class, 'destroy'])->name('alternatif.destroy');

// Routes for Penilaian
Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
Route::get('/penilaian/create', [PenilaianController::class, 'create'])->name('penilaian.create');
Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');
Route::get('/penilaian/{id}/edit', [PenilaianController::class, 'edit'])->name('penilaian.edit');
Route::put('/penilaian/{id}', [PenilaianController::class, 'update'])->name('penilaian.update');
Route::delete('/penilaian/{id}', [PenilaianController::class, 'destroy'])->name('penilaian.destroy');

// Route for SAW calculation
Route::get('/perhitungan/saw', [PerhitunganController::class, 'saw'])->name('perhitungan.saw');

Route::get('/about', function () {
    return view('about');
})->name('about');

