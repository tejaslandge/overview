<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    public function index()
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];

        if (File::exists($logFile)) {
            $fileContent = file($logFile);
            $logs = array_slice($fileContent, -100);
            $logs = array_reverse($logs); // Most recent first
        }

        return view('admin.logs', compact('logs'));
    }

    public function destroy()
    {
        $logFile = storage_path('logs/laravel.log');

        if (File::exists($logFile)) {
            File::put($logFile, '');

            return redirect()->back()->with('success', 'Logs cleared successfully.');
        }

        return redirect()->back()->with('error', 'Log file not found.');
    }
}
