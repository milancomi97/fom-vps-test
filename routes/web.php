<?php

use App\Http\Controllers\Auth\UserConfigController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Modules\CoreModule\Controllers\CoreModuleController;
use App\Modules\Kadrovskaevidencija\Controllers\RadnamestaController;
use App\Modules\Kadrovskaevidencija\Controllers\StrucnakvalifikacijaController;
use App\Modules\Kadrovskaevidencija\Controllers\VrstaradasifarnikController;
use App\Modules\Kadrovskaevidencija\Controllers\ZanimanjasifarnikController;
use App\Modules\Obracunzarada\Controllers\DatotekaobracunskihStatusController;
use App\Modules\Obracunzarada\Controllers\KreditoriController;
use App\Modules\Obracunzarada\Controllers\MaticnadatotekaradnikaController;
use App\Modules\Obracunzarada\Controllers\DatotekaobracunskihkoeficijenataController;
use App\Modules\Obracunzarada\Controllers\MinimalnebrutoosnoviceController;
use App\Modules\Obracunzarada\Controllers\OblikradaController;
use App\Modules\Obracunzarada\Controllers\ObracunZaradaController;
use App\Modules\Obracunzarada\Controllers\PorezdobrinosiController;
use App\Modules\Obracunzarada\Controllers\VrsteplacanjaController;
use App\Modules\Osnovnipodaci\Controllers\FirmaController;
use App\Modules\Osnovnipodaci\Controllers\OrganizacionecelineController;
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

//** OLD Presentation logic, should be refactored  */
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

Route::get('/user/permissions_config', [UserConfigController::class, 'permissionsConfig']);
Route::get('/user/permissions_config_by_user', [UserConfigController::class, 'permissionsConfigByUserId']);


Route::post('/user/permissions_poenter', [UserConfigController::class, 'permissionsUpdatePoenter'])->name('permissionsUpdatePoenter.update');

Route::get('/user/index', [UserConfigController::class, 'index']);

Route::post('/user/permissions_config_update', [UserConfigController::class, 'permissionsUpdate']);

Route::resource("/partner", \App\Http\Controllers\PartnerController::class);
Route::resource("/materijal", \App\Http\Controllers\MaterijalController::class);


Route::middleware('auth')->group(function () {
//    Route::middleware(['auth','customrole'])->group(function () {

        Route::get('obracunzarada/index', [ObracunZaradaController::class, 'index']);
    Route::resource('coremodule', CoreModuleController::class);
    Route::post('getNbsData',[CoreModuleController::class,'sendSoapRequest']);

    //** OLD Presentation logic, should be refactored  END */



    //** Modular logic, custom router cause problem, didn't load properly Facades and Laravel core */
    //** Modules contains Repository for advanced database logic, Views and Controllers and Services for Business Logic */
    //** Static files theme,css etc are in public */
    //** Models, Migrations and Seeders are located in Core Laravel folder structure */
    //** Module architecture stand for customizations based on old Serbian ERP which is refactored in Laravel read Confluence for more*/



    //** Osnovni podaci modul  */
    // Radnici
    // Radnici Maticna datoteka radnika
    Route::get('osnovnipodaci/radnici/index',[RadniciController::class,'index'])->name('radnici.index');

    // Radnici Maticna datoteka radnika END

    Route::get('osnovnipodaci/radnici/create',[RadniciController::class,'create'])->name('radnici.create');
    Route::post('osnovnipodaci/radnici/store',[RadniciController::class,'store'])->name('radnici.store');
//    Route::get('osnovnipodaci/radnici/{radnikId}/edit',[RadniciController::class,'edit'])->name('radnici.edit');
    Route::get('osnovnipodaci/radnici/edit_table',[RadniciController::class,'editRadnik'])->name('radnici.edit_table');

    Route::post('osnovnipodaci/radnici/{radnikId}/update',[RadniciController::class,'update'])->name('radnici.update');


    // Firma podaci
    Route::get('osnovnipodaci/firmapodaci/index',[FirmaController::class,'view'])->name('firmapodaci.view');
    Route::get('osnovnipodaci/firmapodaci/edit',[FirmaController::class,'edit'])->name('firmapodaci.edit');
    Route::post('osnovnipodaci/firmapodaci/update',[FirmaController::class,'update'])->name('firmapodaci.update');



    // Organizacione Celine
    Route::get('osnovnipodaci/organizacioneceline/index',[OrganizacionecelineController::class,'index'])->name('organizacioneceline.index');
    Route::get('osnovnipodaci/organizacioneceline/{id}/edit',[OrganizacionecelineController::class,'edit'])->name('organizacioneceline.edit');
    Route::post('osnovnipodaci/organizacioneceline/post',[OrganizacionecelineController::class,'update'])->name('organizacioneceline.update');


    //** Osnovni podaci modul  KRAJ */


    //** Kadrovska Evidencija modul   */

    // Zanimanja
    Route::get('kadrovskaevidencija/zanimanjasifarnik/index',[ZanimanjasifarnikController::class,'index'])->name('zanimanjasifarnik.index');
    Route::get('kadrovskaevidencija/zanimanjasifarnik/{id}/edit',[ZanimanjasifarnikController::class,'edit'])->name('zanimanjasifarnik.edit');
    Route::post('kadrovskaevidencija/zanimanjasifarnik/post',[ZanimanjasifarnikController::class,'update'])->name('zanimanjasifarnik.update');

    // Radna mesta
    Route::get('kadrovskaevidencija/radnamesta/index',[RadnamestaController::class,'index'])->name('radnamesta.index');
    Route::get('kadrovskaevidencija/radnamesta/{id}/edit',[RadnamestaController::class,'edit'])->name('radnamesta.edit');
    Route::post('kadrovskaevidencija/radnamesta/post',[RadnamestaController::class,'update'])->name('radnamesta.update');

    // Strucna kvalifikacija
    Route::get('kadrovskaevidencija/strucnakvalifikacija/index',[StrucnakvalifikacijaController::class,'index'])->name('strucnakvalifikacija.index');
    Route::get('kadrovskaevidencija/strucnakvalifikacija/{id}/edit',[StrucnakvalifikacijaController::class,'edit'])->name('strucnakvalifikacija.edit');
    Route::post('kadrovskaevidencija/strucnakvalifikacija/post',[StrucnakvalifikacijaController::class,'update'])->name('strucnakvalifikacija.update');

    // Vrste rada
    Route::get('kadrovskaevidencija/vrstaradasifarnik/index',[VrstaradasifarnikController::class,'index'])->name('vrstaradasifarnik.index');
    Route::get('kadrovskaevidencija/vrstaradasifarnik/{id}/edit',[VrstaradasifarnikController::class,'edit'])->name('vrstaradasifarnik.edit');
    Route::post('kadrovskaevidencija/vrstaradasifarnik/post',[VrstaradasifarnikController::class,'update'])->name('vrstaradasifarnik.update');

    //** Kadrovska Evidencija modul kraj   */


    //** Obračun zarada  modul */

    // Oblik rada

    Route::get('obracunzarada/oblikrada/index',[OblikradaController::class,'index'])->name('oblikrada.index');
    Route::get('obracunzarada/oblikrada/{id}/edit',[OblikradaController::class,'edit'])->name('oblikrada.edit');
    Route::post('obracunzarada/oblikrada/post',[OblikradaController::class,'update'])->name('oblikrada.update');

    // Vrste placanja

    Route::get('obracunzarada/vrsteplacanja/index',[VrsteplacanjaController::class,'index'])->name('vrsteplacanja.index');
    Route::get('obracunzarada/vrsteplacanja/{id}/edit',[VrsteplacanjaController::class,'edit'])->name('vrsteplacanja.edit');
    Route::post('obracunzarada/vrsteplacanja/post',[VrsteplacanjaController::class,'update'])->name('vrsteplacanja.update');

    // Kreditori

    Route::get('obracunzarada/kreditori/index',[KreditoriController::class,'index'])->name('kreditori.index');
    Route::get('obracunzarada/kreditori/{id}/edit',[KreditoriController::class,'edit'])->name('kreditori.edit');
    Route::post('obracunzarada/kreditori/post',[KreditoriController::class,'update'])->name('kreditori.update');

    // Minimalne bruto osnovice

    Route::get('obracunzarada/minimalnebrutoosnovice/index',[MinimalnebrutoosnoviceController::class,'index'])->name('minimalnebrutoosnovice.index');
    Route::get('obracunzarada/minimalnebrutoosnovice/{id}/edit',[MinimalnebrutoosnoviceController::class,'edit'])->name('minimalnebrutoosnovice.edit');
    Route::post('obracunzarada/minimalnebrutoosnovice/post',[MinimalnebrutoosnoviceController::class,'update'])->name('minimalnebrutoosnovice.update');

    // Porez i doprinosi

    Route::get('obracunzarada/porezdoprinosi/index',[PorezdobrinosiController::class,'index'])->name('porezdoprinosi.index');
    Route::get('obracunzarada/porezdoprinosi/{id}/edit',[PorezdobrinosiController::class,'edit'])->name('porezdoprinosi.edit');
    Route::post('obracunzarada/porezdoprinosi/post',[PorezdobrinosiController::class,'update'])->name('porezdoprinosi.update');

    // Maticna datoteka radnika

    Route::get('obracunzarada/maticnadatotekaradnika/index',[MaticnadatotekaradnikaController::class,'index'])->name('maticnadatotekaradnika.index');
    Route::get('obracunzarada/maticnadatotekaradnika/edit',[MaticnadatotekaradnikaController::class,'edit'])->name('maticnadatotekaradnika.edit');
    Route::get('obracunzarada/maticnadatotekaradnika/create',[MaticnadatotekaradnikaController::class,'create'])->name('maticnadatotekaradnika.create');
    Route::get('obracunzarada/maticnadatotekaradnika/findByMat',[MaticnadatotekaradnikaController::class,'findByMat'])->name('radnici.findByMat');
    Route::get('obracunzarada/maticnadatotekaradnika/findByPrezime',[MaticnadatotekaradnikaController::class,'findByPrezime'])->name('radnici.findByPrezime');
    Route::get('obracunzarada/maticnadatotekaradnika/getById',[MaticnadatotekaradnikaController::class,'getById'])->name('radnici.getById');
    Route::post('obracunzarada/maticnadatotekaradnika/store',[MaticnadatotekaradnikaController::class,'store'])->name('maticnadatotekaradnika.store');




    // Mesecna datotekaobracunskihkoeficijenata
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/create',[DatotekaobracunskihkoeficijenataController::class,'create'])->name('datotekaobracunskihkoeficijenata.create');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/store',[DatotekaobracunskihkoeficijenataController::class,'store'])->name('datotekaobracunskihkoeficijenata.store');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/getstoredata',[DatotekaobracunskihkoeficijenataController::class,'getStoreData'])->name('datotekaobracunskihkoeficijenata.getStoreData');

    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/update',[DatotekaobracunskihkoeficijenataController::class,'update'])->name('datotekaobracunskihkoeficijenata.update');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/check',[DatotekaobracunskihkoeficijenataController::class,'check'])->name('datotekaobracunskihkoeficijenata.check');
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/show',[DatotekaobracunskihkoeficijenataController::class,'show'])->name('datotekaobracunskihkoeficijenata.show');
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/show_all',[DatotekaobracunskihkoeficijenataController::class,'showAll'])->name('datotekaobracunskihkoeficijenata.show_all');
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/odobravanje',[DatotekaobracunskihkoeficijenataController::class,'odobravanje'])->name('datotekaobracunskihkoeficijenata.odobravanje');

    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/permissionStatusUpdate',[DatotekaobracunskihStatusController::class,'permissionStatusUpdate'])->name('datotekaobracunskihkoeficijenata.updatePermissionStatus');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/updatePermissionStatusAdministrator',[DatotekaobracunskihStatusController::class,'updatePermissionStatusAdministrator'])->name('datotekaobracunskihkoeficijenata.updatePermissionStatusAdministrator');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/getPermissionStatusAdministrator',[DatotekaobracunskihStatusController::class,'getPermissionStatusAdministrator'])->name('datotekaobracunskihkoeficijenata.getPermissionStatusAdministrator');
});



Route::get('nopermission',[PermissionController::class,'index'])->name('noPermission');



require __DIR__.'/auth.php';
