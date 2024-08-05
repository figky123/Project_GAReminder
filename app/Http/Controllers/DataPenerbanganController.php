<?php

namespace App\Http\Controllers;

use App\Models\Penerbangan;

use Illuminate\Http\Request;

class DataPenerbanganController extends Controller
{
    public function index()
    {
        // Fetch paginated data (e.g., 10 records per page)
        $penerbangans = Penerbangan::paginate(10);

        // Pass data to the view
        return view('penerbangan', compact('penerbangans'));
    }

    // Method untuk menyimpan data penerbangan baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nomor_penerbangan' => 'required|string|max:255',

            'jam_penerbangan' => 'required|date_format:H:i',
        ]);

        // Simpan data ke database
        $penerbangan = new Penerbangan();
        $penerbangan->nomor_penerbangan = $request->nomor_penerbangan;
        $penerbangan->jam_penerbangan = $request->jam_penerbangan;
        $penerbangan->rute_penerbangan = $request->rute_penerbangan;
        $penerbangan->save();

        // Redirect kembali ke halaman data penerbangan dengan pesan sukses
        return redirect()->route('penerbangan.index')->with('pesan', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $penerbangan = Penerbangan::findOrFail($id);
        return view('edit_penerbangan', compact('penerbangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_penerbangan' => 'required|string',
            'rute_penerbangan' => 'required|string',
            'jam_penerbangan' => 'required|date_format:H:i',
        ]);

        $penerbangan = Penerbangan::findOrFail($id);
        $penerbangan->update($request->all());

        return redirect()->route('penerbangan.index')->with('pesan', 'Data penerbangan berhasil diupdate!');
    }

    public function destroy($id)
    {
        // Find the penerbangan by ID
        $penerbangan = Penerbangan::findOrFail($id);

        // Delete the penerbangan
        $penerbangan->delete();

        // Redirect with a success message
        return redirect()->route('penerbangan.index')->with('pesan', 'Data penerbangan berhasil dihapus!');
    }
}
