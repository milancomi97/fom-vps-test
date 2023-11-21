<?php

use App\Http\Controllers\ProfileController;
use App\Modules\FirstModule\Controllers\FirstModuleController;
use App\Modules\Obracunzarada\Controllers\ObracunZaradaController;
use App\Modules\Osnovnipodaci\Controllers\FirmaController;
use App\Modules\Osnovnipodaci\Controllers\RadniciController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('/adminlte/welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/templatetheme', function () {
    return view('/adminlte/welcome');
});

Route::post('/materijals_pdf', [\App\Http\Controllers\MaterijalController::class, 'pdfExport'])->name('profile.edit');

Route::get('/user/permissions_config', [\App\Http\Controllers\Auth\UserConfigController::class, 'permissionsConfig']);
Route::get('/user/permissions_config_by_user', [\App\Http\Controllers\Auth\UserConfigController::class, 'permissionsConfigByUserId']);
Route::get('/user/index', [\App\Http\Controllers\Auth\UserConfigController::class, 'index']);

Route::post('/user/permissions_config_update', [\App\Http\Controllers\Auth\UserConfigController::class, 'permissionsUpdate']);

Route::resource("/partner", \App\Http\Controllers\PartnerController::class);
Route::resource("/materijal", \App\Http\Controllers\MaterijalController::class);


Route::middleware('auth')->group(function () {
    Route::get('obracunzarada/index', [ObracunZaradaController::class, 'index']);
    Route::resource('firstmodule', FirstModuleController::class);
    Route::post('getNbsData',[FirstModuleController::class,'sendSoapRequest']);




    //** Osnovni podaci  */
    // Radnici
    Route::get('osnovnipodaci/radnici/index',[RadniciController::class,'index'])->name('radnici.index');

    Route::get('osnovnipodaci/radnici/create',[RadniciController::class,'create'])->name('radnici.create');
    Route::post('osnovnipodaci/radnici/store',[RadniciController::class,'store'])->name('radnici.store');
    Route::get('osnovnipodaci/radnici/{radnikId}/edit',[RadniciController::class,'edit'])->name('radnici.edit');
    Route::post('osnovnipodaci/radnici/{radnikId}/update',[RadniciController::class,'update'])->name('radnici.update');


    // Firma podaci
    Route::get('osnovnipodaci/firmapodaci/index',[FirmaController::class,'view'])->name('firmapodaci.view');
    Route::get('osnovnipodaci/firmapodaci/edit',[FirmaController::class,'edit'])->name('firmapodaci.edit');
    Route::post('osnovnipodaci/firmapodaci/update',[FirmaController::class,'update'])->name('firmapodaci.update');






});






require __DIR__.'/auth.php';
