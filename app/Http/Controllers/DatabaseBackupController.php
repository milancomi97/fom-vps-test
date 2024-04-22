<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function importBackup(){
return '';
    }
}
