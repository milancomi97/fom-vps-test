<?php

use App\Http\Controllers\ProfileController;
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
Route::post('/user/permissions_config_update', [\App\Http\Controllers\Auth\UserConfigController::class, 'permissionsUpdate']);

Route::resource("/partner", \App\Http\Controllers\PartnerController::class);
Route::resource("/materijal", \App\Http\Controllers\MaterijalController::class);

require __DIR__.'/auth.php';
