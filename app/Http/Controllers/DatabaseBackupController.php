<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

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
        $directoryPath = storage_path('backupdb');

        $fullFilePath =$directoryPath."/".$request->file;

        try {
        $response =  exec("gunzip < $fullFilePath | mysql -u ".env('DB_USERNAME')." -p".env('DB_PASSWORD')." ".env('DB_DATABASE'));

        $brojRadnika =User::all()->count();
            return response('Uspešno je importovana baza: '.$request->file.PHP_EOL.' Test komande broj veci od 0: '.$brojRadnika);
        }catch (\Exception $exception){
            return response('EXCEPTION');
        }

//        $process = new Process(['gunzip', '-c', $fullFilePath]);
//        $process->run();
//// Check if the command was successful
//        if (!$process->isSuccessful()) {
//            throw new \RuntimeException($process->getErrorOutput());
//        }
//
//// Get the output of the command (decompressed content)
//        $decompressedContent = $process->getOutput();
//
//// Return the response with the decompressed content

//        return response(exec("gunzip < ".$fullFilePath));
//        DB::unprepared(file_get_contents('./dump.sql'));
//        return response('<p>'.$output.'</p>'.'<h1>Izabrali ste backup NAZIV:'.$request->file.'</h1><h2>TODO sledi logika za import</h2>');
    }
}
