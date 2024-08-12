<?php

namespace App\Http\Controllers;

use App\Exports\HistoriReminderExport;
use App\Models\HistoriReminder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HistoriReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $perPage = 10; // Sesuaikan dengan jumlah data per halaman
        $historiReminders = HistoriReminder::paginate($perPage);
    
        $currentPage = $historiReminders->currentPage();
        $startIndex = ($currentPage - 1) * $perPage + 1;
    
        return view('histori_reminder', compact('historiReminders', 'startIndex'));
    }

    public function export()
    {
        return Excel::download(new HistoriReminderExport, 'Histori_Reminder.xlsx');
    }
}
