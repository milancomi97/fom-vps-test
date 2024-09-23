<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ImportBackupAdvanced extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:import-advanced';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List available backups and allow the user to select one to import';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Step 1: List files in the backup directory
        $directoryPath = storage_path('backupdb');

        if (!is_dir($directoryPath)) {
            $this->error("Backup directory not found at: $directoryPath");
            return Command::FAILURE;
        }

        $files = array_diff(scandir($directoryPath), ['.', '..']);

        if (empty($files)) {
            $this->error('No backup files found in the directory.');
            return Command::FAILURE;
        }

        // Step 2: Display available backup files
        $this->info("Available backup files:");
        foreach ($files as $index => $file) {
            $this->line("[$index] $file");
        }

        // Step 3: Prompt user to select a file
        $selectedIndex = $this->ask('Enter the index of the file you want to import');

        if (!isset($files[$selectedIndex])) {
            $this->error('Invalid selection. Please choose a valid file index.');
            return Command::FAILURE;
        }

        $selectedFile = $files[$selectedIndex];
        $fullFilePath = $directoryPath . '/' . $selectedFile;

        // Step 4: Decompress and import the selected backup file
        try {
            $this->info("Importing backup file: $selectedFile");

            if (pathinfo($fullFilePath, PATHINFO_EXTENSION) === 'gz') {
                $unzippedFile = $this->decompressGzFile($fullFilePath);
            } else {
                $this->error('Invalid file format. Only .gz files are supported.');
                return Command::FAILURE;
            }

            if (!file_exists($unzippedFile)) {
                $this->error('Decompressed file not found.');
                return Command::FAILURE;
            }

            $sqlContent = file_get_contents($unzippedFile);
            DB::unprepared($sqlContent);

            unlink($unzippedFile);

            $userCount = User::count();
            $this->info("Backup imported successfully! Current user count: $userCount");

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Error importing backup: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Decompress a .gz file
     *
     * @param string $filePath
     * @return string
     */
    private function decompressGzFile($filePath)
    {
        $bufferSize = 4096; // Read 4KB at a time
        $outFilePath = str_replace('.gz', '', $filePath);

        $file = gzopen($filePath, 'rb');
        $outFile = fopen($outFilePath, 'wb');

        while (!gzeof($file)) {
            fwrite($outFile, gzread($file, $bufferSize));
        }

        fclose($outFile);
        gzclose($file);

        return $outFilePath;
    }
}
