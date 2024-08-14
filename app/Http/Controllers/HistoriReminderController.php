<?php

namespace App\Http\Controllers;

use App\Exports\HistoriReminderExport;
use App\Models\HistoriReminder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use PDF; // Import facade PDF
class HistoriReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        Carbon::setLocale('id');
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

    public function exportPdf()
    {
        \Log::info('Export PDF method called'); // Tambahkan log
        $historiReminders = HistoriReminder::with('reminder', 'penerbangan')->get();
        $pdf = Pdf::loadView('pdf', compact('historiReminders'));
        return $pdf->download('Histori_Reminder.pdf');
    }

    public function destroy($id)
    {
        // Logic to delete the reminder
        $historiReminder = HistoriReminder::findOrFail($id);
        $historiReminder->delete();

        return redirect()->back()->with('pesan', 'Data berhasil dihapus!');
    }
}
