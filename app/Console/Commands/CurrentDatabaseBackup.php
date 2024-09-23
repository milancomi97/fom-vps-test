<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class CurrentDatabaseBackup extends Command
{
    // Update the command signature and description
    protected $signature = 'backup:currentday';
    protected $description = 'Backup the current day database and store it as a gzipped file.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // MySQL credentials
        $dbUser = env('DB_USERNAME', 'root');
        $dbPass = env('DB_PASSWORD', 'root');
        $dbName = env('DB_DATABASE', 'laravel_database');

        // Backup directory
        $backupDir = storage_path('backupdb');

        // Ensure backup directory exists
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        // Set timezone
        date_default_timezone_set('Europe/Belgrade');

        // Date format for backup file
        $date = date('d_m_Y_H_i');

        // Backup file path
        $backupFile = "$backupDir/backup_$date.sql.gz";

        // Construct the mysqldump command
        $dumpCommand = "mysqldump -u $dbUser -p$dbPass $dbName | gzip > $backupFile";

        // Execute the command
        $output = null;
        $resultCode = null;
        exec($dumpCommand, $output, $resultCode);

        // Check if the backup was successful
        if ($resultCode === 0) {
            $this->info("Database backup was successful. Backup file: $backupFile");
        } else {
            $this->error('Database backup failed!');
        }

        return 0;
    }
}
