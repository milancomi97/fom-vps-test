<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DatabaseBackupController extends Controller
{

    public function showBackupData(){
        $directoryPath = storage_path('backupdb'); // Replace 'public' with your directory name

        // Get all files from the directory
        $files = scandir($directoryPath);

        // Remove '.' and '..' from the list
        $files = array_diff($files, ['.', '..']);

        // Pass the files array to the view
        return view('backuptool.index', ['files' => $files]);
    }

    public function importBackup(Request $request){
//        Artisan::call('migrate:fresh', []);
//        $output = Artisan::output();
        $directoryPath = storage_path('backupdb'); // Replace 'public' with your directory name

        return response(file_get_contents($directoryPath.'/'.$request->file));
//        DB::unprepared(file_get_contents('./dump.sql'));
//        return response('<p>'.$output.'</p>'.'<h1>Izabrali ste backup NAZIV:'.$request->file.'</h1><h2>TODO sledi logika za import</h2>');
    }
}
