<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\UserConfigController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Modules\CoreModule\Controllers\CoreModuleController;
use App\Modules\Kadrovskaevidencija\Controllers\RadnamestaController;
use App\Modules\Kadrovskaevidencija\Controllers\StrucnakvalifikacijaController;
use App\Modules\Kadrovskaevidencija\Controllers\VrstaradasifarnikController;
use App\Modules\Kadrovskaevidencija\Controllers\ZanimanjasifarnikController;
use App\Modules\Obracunzarada\Controllers\ArhivaController;
use App\Modules\Obracunzarada\Controllers\DatotekaobracunskihEmailController;
use App\Modules\Obracunzarada\Controllers\DatotekaobracunskihExportController;
use App\Modules\Obracunzarada\Controllers\DatotekaobracunskihStatusController;
use App\Modules\Obracunzarada\Controllers\DpsmAkontacijeController;
use App\Modules\Obracunzarada\Controllers\DpsmFiksnaPlacanjaController;
use App\Modules\Obracunzarada\Controllers\DpsmKreditiController;
use App\Modules\Obracunzarada\Controllers\DpsmPoentazaslogController;
use App\Modules\Obracunzarada\Controllers\IzvestajZaradaController;
use App\Modules\Obracunzarada\Controllers\KreditoriController;
use App\Modules\Obracunzarada\Controllers\MaticnadatotekaradnikaController;
use App\Modules\Obracunzarada\Controllers\DatotekaobracunskihkoeficijenataController;
use App\Modules\Obracunzarada\Controllers\MinimalnebrutoosnoviceController;
use App\Modules\Obracunzarada\Controllers\OblikradaController;
use App\Modules\Obracunzarada\Controllers\ObracunZaradaController;
use App\Modules\Obracunzarada\Controllers\ObradaPripremaController;
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


Route::get('/details', function () {
    //RAM usage

    $free = shell_exec('free');
    $free = (string)trim($free);
    $free_arr = explode("\n", $free);
    $mem = explode(" ", $free_arr[1]);
    $mem = array_filter($mem);
    $mem = array_merge($mem);
    $usedmem = $mem[2];
    $usedmemInGB = number_format($usedmem / 1048576, 2) . ' GB';
    $memory1 = $mem[2] / $mem[1] * 100;
    $memory = round($memory1) . '%';
    $fh = fopen('/proc/meminfo', 'r');
    $mem = 0;
    while ($line = fgets($fh)) {
        $pieces = array();
        if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
            $mem = $pieces[1];
            break;
        }
    }

    fclose($fh);
    $totalram = number_format($mem / 1048576, 2) . ' GB';

    //cpu usage
    $cpu_load = sys_getloadavg();
    $load = $cpu_load[0] . '% / 100%';

    return view('details', compact('memory', 'totalram', 'usedmemInGB', 'load'));
});

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


//Route::middleware('auth')->group(function () {
Route::group(['middleware' => ['auth']], function () {
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


    Route::get('/backupdata', [\App\Http\Controllers\DatabaseBackupController::class, 'showBackupData'])->name('backup.index');

    Route::post('/backupdata', [\App\Http\Controllers\DatabaseBackupController::class, 'importBackup'])->name('backup.import');


    Route::get('/forgot-password-cust/{token}', function (string $token) {

        return view('auth.forgot-password-cust', ['email' => auth()->user()->email, 'token' => $token, 'request' => ['route' => $token]]);
    })->name('password.request_cust');


    Route::post('reset-password-cust', [NewPasswordController::class, 'storecust'])
        ->name('password-cust.store');


    Route::resource('coremodule', CoreModuleController::class);
    Route::get('getNbsData', [CoreModuleController::class, 'sendSoapRequest']);

    //** OLD Presentation logic, should be refactored  END */


    //** Modular logic, custom router cause problem, didn't load properly Facades and Laravel core */
    //** Modules contains Repository for advanced database logic, Views and Controllers and Services for Business Logic */
    //** Static files theme,css etc are in public */
    //** Models, Migrations and Seeders are located in Core Laravel folder structure */
    //** Module architecture stand for customizations based on old Serbian ERP which is refactored in Laravel read Confluence for more*/


    //** Osnovni podaci modul  */
    // Radnici
    // Radnici Maticna datoteka radnika
    Route::get('osnovnipodaci/radnici/index', [RadniciController::class, 'index'])->name('radnici.index');

    // Radnici Maticna datoteka radnika END

    Route::get('osnovnipodaci/radnici/create', [RadniciController::class, 'create'])->name('radnici.create');
    Route::post('osnovnipodaci/radnici/store', [RadniciController::class, 'store'])->name('radnici.store');
//    Route::get('osnovnipodaci/radnici/{radnikId}/edit',[RadniciController::class,'edit'])->name('radnici.edit');
    Route::get('osnovnipodaci/radnici/edit_table', [RadniciController::class, 'editRadnik'])->name('radnici.edit_table');

    Route::post('osnovnipodaci/radnici/{radnikId}/update', [RadniciController::class, 'update'])->name('radnici.update');


    // Firma podaci
    Route::get('osnovnipodaci/firmapodaci/index', [FirmaController::class, 'view'])->name('firmapodaci.view');
    Route::get('osnovnipodaci/firmapodaci/edit', [FirmaController::class, 'edit'])->name('firmapodaci.edit');
    Route::post('osnovnipodaci/firmapodaci/update', [FirmaController::class, 'update'])->name('firmapodaci.update');


    // Organizacione Celine
    Route::get('osnovnipodaci/organizacioneceline/index', [OrganizacionecelineController::class, 'index'])->name('organizacioneceline.index');
    Route::get('osnovnipodaci/organizacioneceline/{id}/edit', [OrganizacionecelineController::class, 'edit'])->name('organizacioneceline.edit');
    Route::post('osnovnipodaci/organizacioneceline/post', [OrganizacionecelineController::class, 'update'])->name('organizacioneceline.update');


    //** Osnovni podaci modul  KRAJ */


    //** Kadrovska Evidencija modul   */

    // Zanimanja
    Route::get('kadrovskaevidencija/zanimanjasifarnik/index', [ZanimanjasifarnikController::class, 'index'])->name('zanimanjasifarnik.index');
    Route::get('kadrovskaevidencija/zanimanjasifarnik/{id}/edit', [ZanimanjasifarnikController::class, 'edit'])->name('zanimanjasifarnik.edit');
    Route::post('kadrovskaevidencija/zanimanjasifarnik/post', [ZanimanjasifarnikController::class, 'update'])->name('zanimanjasifarnik.update');

    // Radna mesta
    Route::get('kadrovskaevidencija/radnamesta/index', [RadnamestaController::class, 'index'])->name('radnamesta.index');
    Route::get('kadrovskaevidencija/radnamesta/{id}/edit', [RadnamestaController::class, 'edit'])->name('radnamesta.edit');
    Route::post('kadrovskaevidencija/radnamesta/post', [RadnamestaController::class, 'update'])->name('radnamesta.update');

    // Strucna kvalifikacija
    Route::get('kadrovskaevidencija/strucnakvalifikacija/index', [StrucnakvalifikacijaController::class, 'index'])->name('strucnakvalifikacija.index');
    Route::get('kadrovskaevidencija/strucnakvalifikacija/{id}/edit', [StrucnakvalifikacijaController::class, 'edit'])->name('strucnakvalifikacija.edit');
    Route::post('kadrovskaevidencija/strucnakvalifikacija/post', [StrucnakvalifikacijaController::class, 'update'])->name('strucnakvalifikacija.update');

    // Vrste rada
    Route::get('kadrovskaevidencija/vrstaradasifarnik/index', [VrstaradasifarnikController::class, 'index'])->name('vrstaradasifarnik.index');
    Route::get('kadrovskaevidencija/vrstaradasifarnik/{id}/edit', [VrstaradasifarnikController::class, 'edit'])->name('vrstaradasifarnik.edit');
    Route::post('kadrovskaevidencija/vrstaradasifarnik/post', [VrstaradasifarnikController::class, 'update'])->name('vrstaradasifarnik.update');

    //** Kadrovska Evidencija modul kraj   */


    //** Obračun zarada  modul */

    // Oblik rada

    Route::get('obracunzarada/oblikrada/index', [OblikradaController::class, 'index'])->name('oblikrada.index');
    Route::get('obracunzarada/oblikrada/{id}/edit', [OblikradaController::class, 'edit'])->name('oblikrada.edit');
    Route::post('obracunzarada/oblikrada/post', [OblikradaController::class, 'update'])->name('oblikrada.update');

    // Vrste placanja

    Route::get('obracunzarada/vrsteplacanja/index', [VrsteplacanjaController::class, 'index'])->name('vrsteplacanja.index');
    Route::get('obracunzarada/vrsteplacanja/{id}/edit', [VrsteplacanjaController::class, 'edit'])->name('vrsteplacanja.edit');
    Route::post('obracunzarada/vrsteplacanja/post', [VrsteplacanjaController::class, 'update'])->name('vrsteplacanja.update');

    // Kreditori

    Route::get('obracunzarada/kreditori/index', [KreditoriController::class, 'index'])->name('kreditori.index');
    Route::get('obracunzarada/kreditori/{id}/edit', [KreditoriController::class, 'edit'])->name('kreditori.edit');
    Route::post('obracunzarada/kreditori/post', [KreditoriController::class, 'update'])->name('kreditori.update');

    // Minimalne bruto osnovice

    Route::get('obracunzarada/minimalnebrutoosnovice/index', [MinimalnebrutoosnoviceController::class, 'index'])->name('minimalnebrutoosnovice.index');
    Route::get('obracunzarada/minimalnebrutoosnovice/{id}/edit', [MinimalnebrutoosnoviceController::class, 'edit'])->name('minimalnebrutoosnovice.edit');
    Route::post('obracunzarada/minimalnebrutoosnovice/post', [MinimalnebrutoosnoviceController::class, 'update'])->name('minimalnebrutoosnovice.update');

    // Porez i doprinosi

    Route::get('obracunzarada/porezdoprinosi/index', [PorezdobrinosiController::class, 'index'])->name('porezdoprinosi.index');
    Route::get('obracunzarada/porezdoprinosi/{id}/edit', [PorezdobrinosiController::class, 'edit'])->name('porezdoprinosi.edit');
    Route::post('obracunzarada/porezdoprinosi/post', [PorezdobrinosiController::class, 'update'])->name('porezdoprinosi.update');

    // Maticna datoteka radnika

    Route::get('obracunzarada/maticnadatotekaradnika/index', [MaticnadatotekaradnikaController::class, 'index'])->name('maticnadatotekaradnika.index');
    Route::get('obracunzarada/maticnadatotekaradnika/edit', [MaticnadatotekaradnikaController::class, 'edit'])->name('maticnadatotekaradnika.edit');
    Route::get('obracunzarada/maticnadatotekaradnika/create', [MaticnadatotekaradnikaController::class, 'create'])->name('maticnadatotekaradnika.create');
    Route::get('obracunzarada/maticnadatotekaradnika/findByMat', [MaticnadatotekaradnikaController::class, 'findByMat'])->name('radnici.findByMat');
    Route::get('obracunzarada/maticnadatotekaradnika/findByPrezime', [MaticnadatotekaradnikaController::class, 'findByPrezime'])->name('radnici.findByPrezime');
    Route::get('obracunzarada/maticnadatotekaradnika/getById', [MaticnadatotekaradnikaController::class, 'getById'])->name('radnici.getById');
    Route::post('obracunzarada/maticnadatotekaradnika/store', [MaticnadatotekaradnikaController::class, 'store'])->name('maticnadatotekaradnika.store');

    Route::get('obracunzarada/maticnadatotekaradnika/edit_by_userId', [MaticnadatotekaradnikaController::class, 'editByUserId'])->name('maticnadatotekaradnika.editByUserId');
    Route::get('obracunzarada/maticnadatotekaradnika/create_from_user', [MaticnadatotekaradnikaController::class, 'createFromUser'])->name('maticnadatotekaradnika.createFromUser');


    // Mesecna datotekaobracunskihkoeficijenata
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/create', [DatotekaobracunskihkoeficijenataController::class, 'create'])->name('datotekaobracunskihkoeficijenata.create');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/store', [DatotekaobracunskihkoeficijenataController::class, 'store'])->name('datotekaobracunskihkoeficijenata.store');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/getstoredata', [DatotekaobracunskihkoeficijenataController::class, 'getStoreData'])->name('datotekaobracunskihkoeficijenata.getStoreData');

    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/getmonthbyid', [DatotekaobracunskihkoeficijenataController::class, 'getMonthDataById'])->name('datotekaobracunskihkoeficijenata.getMonthDataById');

    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/store_update', [DatotekaobracunskihkoeficijenataController::class, 'storeUpdate'])->name('datotekaobracunskihkoeficijenata.store_update');

    // POENTERSKI UNOS

    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/update', [DatotekaobracunskihkoeficijenataController::class, 'update'])->name('datotekaobracunskihkoeficijenata.update');
//    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/check', [DatotekaobracunskihkoeficijenataController::class, 'check'])->name('datotekaobracunskihkoeficijenata.check');
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/odobravanje', [DatotekaobracunskihkoeficijenataController::class, 'odobravanje'])->name('datotekaobracunskihkoeficijenata.odobravanje');

    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/odobravanje_poenter', [DatotekaobracunskihkoeficijenataController::class, 'odobravanjePoenter'])->name('datotekaobracunskihkoeficijenata.odobravanje_poenter');
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/odobravanje_check_sati', [DatotekaobracunskihkoeficijenataController::class, 'odobravanjeCheckSati'])->name('datotekaobracunskihkoeficijenata.odobravanje_check_sati');


    Route::POST('obracunzarada/datotekaobracunskihkoeficijenata/odobravanje_xls', [DatotekaobracunskihExportController::class, 'odobravanjeExportXls'])->name('datotekaobracunskihkoeficijenata.odobravanje_export_xls');
    Route::POST('obracunzarada/datotekaobracunskihkoeficijenata/odobravanje_pdf_test', [DatotekaobracunskihExportController::class, 'odobravanjeExportPdfTest'])->name('datotekaobracunskihkoeficijenata.odobravanje_export_pdf_test');
    Route::POST('obracunzarada/datotekaobracunskihkoeficijenata/odobravanje_pdf_po_org_cel', [DatotekaobracunskihExportController::class, 'odobravanjeExportPdf'])->name('datotekaobracunskihkoeficijenata.odobravanje_export_pdf_org_celine');

    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/stampa_radnik_lista', [DatotekaobracunskihExportController::class, 'stampaRadnikLista'])->name('datotekaobracunskihkoeficijenata.stampa_radnik_lista');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/stampa_ostvarene_zarade', [DatotekaobracunskihExportController::class, 'stampaOstvareneZarade'])->name('datotekaobracunskihkoeficijenata.stampa_ostvarene_zarade');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/stampa_rang_liste', [DatotekaobracunskihExportController::class, 'stampaRangListe'])->name('datotekaobracunskihkoeficijenata.stampa_rang_liste');

    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/email_radnik_lista', [DatotekaobracunskihEmailController::class, 'emailRadnikLista'])->name('datotekaobracunskihkoeficijenata.email_radnik_lista');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/email_ostvarene_zarade', [DatotekaobracunskihEmailController::class, 'emailOstvareneZarade'])->name('datotekaobracunskihkoeficijenata.email_ostvarene_zarade');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/email_rang_liste', [DatotekaobracunskihEmailController::class, 'emailRangListe'])->name('datotekaobracunskihkoeficijenata.email_rang_liste');


    // UNOS VARIJABILNIH
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/show_all', [DpsmPoentazaslogController::class, 'showAll'])->name('datotekaobracunskihkoeficijenata.show_all');
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/show', [DpsmPoentazaslogController::class, 'show'])->name('datotekaobracunskihkoeficijenata.show');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/updateVariabilna', [DpsmPoentazaslogController::class, 'updateVariabilna'])->name('datotekaobracunskihkoeficijenata.updateVariabilna');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/deleteVariabilna', [DpsmPoentazaslogController::class, 'deleteVariabilna'])->name('datotekaobracunskihkoeficijenata.deleteVariabilna');

    // AKONTACIJE
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/show_all_akontacije', [DpsmAkontacijeController::class, 'showAllAkontacije'])->name('datotekaobracunskihkoeficijenata.show_all_akontacije');
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/show_akontacije', [DpsmAkontacijeController::class, 'showAkontacije'])->name('datotekaobracunskihkoeficijenata.show_akontacije');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/update_akontacije', [DpsmAkontacijeController::class, 'updateAkontacije'])->name('datotekaobracunskihkoeficijenata.update_akontacije');


    // FIKSNA PLACANJA
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/show_all_fiksnap', [DpsmFiksnaPlacanjaController::class, 'showAllFiksnap'])->name('datotekaobracunskihkoeficijenata.show_all_fiksnap');
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/show_fiksnap', [DpsmFiksnaPlacanjaController::class, 'showFiksnap'])->name('datotekaobracunskihkoeficijenata.show_fiksnap');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/update_fiksnap', [DpsmFiksnaPlacanjaController::class, 'updateFiksnap'])->name('datotekaobracunskihkoeficijenata.update_fiksnap');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/delete_fiksnap', [DpsmFiksnaPlacanjaController::class, 'deleteFiksnap'])->name('datotekaobracunskihkoeficijenata.delete_fiksnap');


    // KREDITI
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/show_all_krediti', [DpsmKreditiController::class, 'showAllKrediti'])->name('datotekaobracunskihkoeficijenata.show_all_krediti');
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/show_krediti', [DpsmKreditiController::class, 'showKrediti'])->name('datotekaobracunskihkoeficijenata.show_krediti');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/update_krediti', [DpsmKreditiController::class, 'updateKrediti'])->name('datotekaobracunskihkoeficijenata.update_krediti');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/delete_krediti', [DpsmKreditiController::class, 'deleteKrediti'])->name('datotekaobracunskihkoeficijenata.delete_krediti');


    // Obracun zarada

    Route::get('obracunzarada/index', [ObracunZaradaController::class, 'index']);


    // Mesecna Obrada

    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/mesecna_obrada_index', [ObradaPripremaController::class, 'obradaIndex'])->name('datotekaobracunskihkoeficijenata.mesecna_obrada_index');
//    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/mesecna_obrada_index',[ObradaPripremaController::class,'obradaShow'])->name('datotekaobracunskihkoeficijenata.mesecna_obrada_index');

    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/obrada_radnik', [ObracunZaradaController::class, 'obradaRadnik'])->name('datotekaobracunskihkoeficijenata.obrada_radnik');
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/show_all_plate', [ObracunZaradaController::class, 'showAllPlate'])->name('datotekaobracunskihkoeficijenata.show_all_plate');
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/show_plate', [ObracunZaradaController::class, 'showPlate'])->name('datotekaobracunskihkoeficijenata.show_plate');

    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/email_radnik', [ObracunZaradaController::class, 'emailRadnik'])->name('datotekaobracunskihkoeficijenata.email_radnik');


    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/permissionStatusUpdate', [DatotekaobracunskihStatusController::class, 'permissionStatusUpdate'])->name('datotekaobracunskihkoeficijenata.updatePermissionStatus');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/updatePermissionStatusAdministrator', [DatotekaobracunskihStatusController::class, 'updatePermissionStatusAdministrator'])->name('datotekaobracunskihkoeficijenata.updatePermissionStatusAdministrator');
    Route::post('obracunzarada/datotekaobracunskihkoeficijenata/getPermissionStatusAdministrator', [DatotekaobracunskihStatusController::class, 'getPermissionStatusAdministrator'])->name('datotekaobracunskihkoeficijenata.getPermissionStatusAdministrator');
    Route::get('obracunzarada/datotekaobracunskihkoeficijenata/odobravanje_check_poenteri', [DatotekaobracunskihStatusController::class, 'odobravanjeCheckPoenteri'])->name('datotekaobracunskihkoeficijenata.odobravanje_check_poenteri');


    // Izvestaji
    Route::get('obracunzarada/izvestaji/ranglistazarade', [IzvestajZaradaController::class, 'ranglistazarade'])->name('izvestaj.ranglistazarade');
    Route::get('obracunzarada/izvestaji/rekapitulacijazarade', [IzvestajZaradaController::class, 'rekapitulacijazarade'])->name('izvestaj.rekapitulacijazarade');


    // Arhiva
    Route::get('obracunzarada/arhiva/index', [ArhivaController::class, 'index'])->name('arhiva.index');
    Route::get('obracunzarada/arhiva/mesec', [ArhivaController::class, 'mesec'])->name('arhiva.mesec');
    Route::get('obracunzarada/arhiva/radnik', [ArhivaController::class, 'radnik'])->name('arhiva.radnik');


    Route::get('obracunzarada/arhiva/arhivaMaticneDatoteke', [ArhivaController::class, 'arhivaMaticneDatoteke'])->name('arhiva.arhivaMaticneDatoteke');
    Route::get('obracunzarada/arhiva/obracunskeListe', [ArhivaController::class, 'obracunskeListe'])->name('arhiva.obracunskeListe');
    Route::get('obracunzarada/arhiva/ukupnaRekapitulacija', [ArhivaController::class, 'ukupnaRekapitulacija'])->name('arhiva.ukupnaRekapitulacija');

    Route::get('obracunzarada/arhiva/potvrdaProseka', [ArhivaController::class, 'potvrdaProseka'])->name('arhiva.potvrdaProseka');
    Route::get('obracunzarada/arhiva/godisnjiKarton', [ArhivaController::class, 'godisnjiKarton'])->name('arhiva.godisnjiKarton');
    Route::get('obracunzarada/arhiva/pppPrijava', [ArhivaController::class, 'pppPrijava'])->name('arhiva.pppPrijava');


});


Route::get('nopermission', [PermissionController::class, 'index'])->name('noPermission');


require __DIR__ . '/auth.php';
