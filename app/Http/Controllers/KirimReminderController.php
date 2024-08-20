<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Models\Penerbangan;
use App\Models\HistoriReminder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class KirimReminderController extends Controller
{
    // Menampilkan halaman form
    public function index()
    {
        $penerbanganValues = Penerbangan::pluck('nomor_penerbangan')->unique();
        return view('kirim_reminder', compact('penerbanganValues'));
    }

    // Menyimpan data dan mengirim reminder
    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'no_hp.*' => 'required|digits_between:10,15', // Validasi setiap nomor telepon
            'isi_pesan' => 'required',
            'status_tiket' => 'required',
            'tgl_berangkat' => 'required|date',
            'gambar_pesan' => 'required|image',
            'nomor_penerbangan' => [
                'required',
                Rule::in(Penerbangan::pluck('nomor_penerbangan')->toArray())
            ],
        ]);

        // Menyimpan file gambar ke storage
        $gambarPath = $request->file('gambar_pesan')->store('gambar_pesan', 'public');

        // Menggabungkan nomor telepon dengan delimiter (misalnya koma)
        $noHpString = implode(', ', $request->input('no_hp'));

        // Menyimpan data ke tabel reminders
        $reminder = Reminder::create([
            'no_hp' => $noHpString, // Simpan nomor telepon sebagai string dengan delimiter
            'isi_pesan' => $request->input('isi_pesan'),
            'status_tiket' => $request->input('status_tiket'),
            'ket_pesan' => $request->input('ket_pesan'),
            'tgl_berangkat' => $request->input('tgl_berangkat'),
            'gambar_pesan' => $gambarPath,
        ]);

        // Mengambil id_penerbangan dari tabel penerbangan berdasarkan nomor penerbangan
        $penerbangan = Penerbangan::where('nomor_penerbangan', $request->input('nomor_penerbangan'))->first();

        // Menyimpan data ke tabel histori_reminders
        HistoriReminder::create([
            'id_reminder' => $reminder->id,
            'id_penerbangan' => $penerbangan->id,
        ]);

        // Mengirim SMS melalui Zenziva tanpa gambar
        $phoneNumbers = $request->input('no_hp');
        $this->sendSmsToMultipleNumbers($phoneNumbers, $request->input('isi_pesan'));
        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('pesan', 'Reminder berhasil dikirim.');
    }

    // Fungsi untuk mengirim SMS menggunakan Zenziva
    protected function sendSmsToMultipleNumbers($phoneNumbers, $message)
    {
        // Check if the message exceeds 1000 characters
        if (strlen($message) > 1000) {
            throw new \Exception('Pesan tidak boleh melebihi 1000 karakter.');
        }

        $userkey = env('ZENZIVA_USERKEY');
        $passkey = env('ZENZIVA_PASSKEY');

        foreach ($phoneNumbers as $phoneNumber) {
            $response = Http::asForm()->post('https://console.zenziva.net/wareguler/api/sendWA/', [
                'userkey' => $userkey,
                'passkey' => $passkey,
                'to' => $phoneNumber,
                'message' => $message,
            ]);

            // Debug: Log response
            \Log::info('Zenziva API response for number ' . $phoneNumber . ': ' . $response->body());

            if (!$response->successful()) {
                throw new \Exception('Gagal mengirim pesan melalui Zenziva: ' . $response->body());
            }
        }
    }

    protected function normalizePhoneNumbers($phoneNumbers)
    {
        // Remove spaces, dashes, and other non-numeric characters
        $normalizedNumbers = array_map(function ($number) {
            return preg_replace('/\D/', '', $number);
        }, $phoneNumbers);

        // Prepend country code if necessary
        // Example for Indonesia: +62
        $normalizedNumbers = array_map(function ($number) {
            return '+62' . ltrim($number, '0');
        }, $normalizedNumbers);

        return implode(', ', $normalizedNumbers);
    }
}
