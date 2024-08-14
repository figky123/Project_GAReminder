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

        // Pass these values to the view
        return view('kirim_reminder', compact('penerbanganValues'));
    }

   

    // Menyimpan data dan mengirim reminder
    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'no_hp' => 'required',
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
        $gambarUrl = Storage::url($gambarPath); // URL gambar untuk dikirim
    
        // Menyimpan data ke tabel reminders
        $reminder = Reminder::create([
            'no_hp' => $request->input('no_hp'),
            'isi_pesan' => $request->input('isi_pesan'),
            'status_tiket' => $request->input('status_tiket'),
            'ket_pesan' => $request->input('ket_pesan'),
            'tgl_berangkat' => $request->input('tgl_berangkat'),
            'gambar_pesan' => $gambarPath, // Simpan path gambar di kolom gambar_pesan
        ]);
    
        // Mengambil id_penerbangan dari tabel penerbangan berdasarkan nomor penerbangan
        $penerbangan = Penerbangan::where('nomor_penerbangan', $request->input('nomor_penerbangan'))->first();
    
        // Menyimpan data ke tabel histori_reminders
        HistoriReminder::create([
            'id_reminder' => $reminder->id,
            'id_penerbangan' => $penerbangan->id,
        ]);
    
        // Mengirim SMS melalui Zenziva dengan gambar
        $this->sendSms($request->input('no_hp'), $request->input('isi_pesan'), $gambarUrl);
    
        // Redirect ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('pesan', 'Reminder berhasil dikirim.');
    }
    
    // Fungsi untuk mengirim SMS menggunakan Zenziva, beserta gambar jika didukung
    protected function sendSms($phoneNumber, $message)
    {
        // Check if the message exceeds 1000 characters
        if (strlen($message) > 1000) {
            throw new \Exception('Pesan tidak boleh melebihi 1000 karakter.');
        }

        $userkey = env('ZENZIVA_USERKEY');
        $passkey = env('ZENZIVA_PASSKEY');

        $response = Http::asForm()->post('https://console.zenziva.net/wareguler/api/sendWA/', [
            'userkey' => $userkey,
            'passkey' => $passkey,
            'to' => $phoneNumber,
            'message' => $message,
        ]);

        if (!$response->successful()) {
            throw new \Exception('Gagal mengirim pesan melalui Zenziva: ' . $response->body());
        }
    }
}
