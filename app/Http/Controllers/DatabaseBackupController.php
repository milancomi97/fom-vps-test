<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DatabaseBackupController extends Controller
{
    public function showBackupData()
    {
        $directoryPath = storage_path('backupdb');
        $files = scandir($directoryPath);
        $files = array_diff($files, ['.', '..']);
        return view('backuptool.index', ['files' => $files]);
    }

    public function importBackup(Request $request)
    {
        $directoryPath = storage_path('backupdb');
        $fullFilePath = $directoryPath . "/" . $request->file;

        try {
            // Prepare the gunzip and MySQL import command
            $command = "gunzip < $fullFilePath | mysql -u " . escapeshellarg(env('DB_USERNAME')) .
                " -p" . escapeshellarg(env('DB_PASSWORD')) . " " . escapeshellarg(env('DB_DATABASE'));

            $process = new Process([$command]);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            $output = $process->getOutput();
            $brojRadnika = User::count();

            return response()->json([
                'message' => 'Backup imported successfully: ' . $request->file,
                'number_of_users' => $brojRadnika
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
