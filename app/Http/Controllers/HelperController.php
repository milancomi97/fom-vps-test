<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;

class HelperController extends Controller
{

    public function showLog()
    {
        // Define the path to the log file
        $path = storage_path('logs/evidencija_dodavanja_poentera.log');

        // Check if the log file exists
        if (File::exists($path)) {
            // Read the log file
            $log = File::get($path);

            // Optionally limit the number of lines to avoid loading large files
            $logLines = explode("\n", $log);
//            $logLines = array_slice($logLines, -1000); // Show only the last 100 lines

            $reverseLogLines= array_reverse($logLines);
            // Format it for display in the browser (or just return as text)
            return response()->view('poenter_log_review', ['log' => $reverseLogLines]);
        } else {
            return response('Log file does not exist.', 404);
        }
    }

}
