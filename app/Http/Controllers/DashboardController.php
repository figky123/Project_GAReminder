<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Models\HistoriReminder;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah status tiket
        $statusTiketData = [
            'OK' => Reminder::where('status_tiket', 'OK')->count(),
            'Irregularity' => Reminder::where('status_tiket', 'Irregularity')->count()
        ];

        // Ambil data jumlah penumpang berdasarkan nomor penerbangan
        // Hitung jumlah id_historireminders berdasarkan nomor penerbangan
        $flightCounts = DB::table('historireminders')
        ->select('penerbangans.nomor_penerbangan', DB::raw('COUNT(historireminders.id) as count'))
        ->join('penerbangans', 'historireminders.id_penerbangan', '=', 'penerbangans.id')
        ->whereIn('penerbangans.nomor_penerbangan', ['GA175', 'GA177', 'GA179'])
        ->groupBy('penerbangans.nomor_penerbangan')
        ->pluck('count', 'penerbangans.nomor_penerbangan')
        ->toArray();

    return view('dashboard', compact('statusTiketData', 'flightCounts'));
}
    
}
