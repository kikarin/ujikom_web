<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agenda;
use App\Models\Info;
use App\Models\Gallery;
use App\Models\Album;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total data
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $userCount = User::where('role', 'user')->count();
        $totalAgendas = Agenda::count();
        $totalInfos = Info::count();
        $totalGalleries = Gallery::count();
        $totalAlbums = Album::count();
    
        // Membaca log file untuk aktivitas terbaru
        $logFile = storage_path('logs/laravel.log');
        $recentLogs = [];
    
        if (File::exists($logFile)) {
            $logs = array_reverse(file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)); // Membalik urutan log
            foreach ($logs as $log) {
                // Pastikan log memiliki format timestamp
                if (preg_match('/^\[(.*?)\] (.*?)\: (.*)/', $log, $matches)) {
                    $recentLogs[] = [
                        'timestamp' => $matches[1],
                        'level' => $matches[2],
                        'message' => $matches[3],
                    ];
                }
    
                if (count($recentLogs) >= 10) {
                    break; // Ambil maksimal 10 log
                }
            }
        }
    
        // Mengirim data ke view
        return view('admin.dashboard', compact(
            'totalUsers',
            'adminCount',
            'userCount',
            'totalAgendas',
            'totalInfos',
            'totalGalleries',
            'totalAlbums',
            'recentLogs'
        ));
    }
    
}
