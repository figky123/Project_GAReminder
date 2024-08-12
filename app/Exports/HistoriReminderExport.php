<?php

namespace App\Exports;

use App\Models\HistoriReminder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoriReminderExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Ambil data yang ingin diekspor
        return HistoriReminder::all(['no_hp', 'nomor_penerbangan', 'tgl_berangkat', 'status_tiket', 'ket_pesan']);
    }

    public function headings(): array
    {
        // Header kolom di file Excel
        return [
            'Nomor Telepon',
            'Nomor Penerbangan',
            'Tanggal Keberangkatan',
            'Status Tiket',
            'Keterangan',
        ];
    }
}
