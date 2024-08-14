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
            'nomor_penerbangan' => [
                'required',
                'regex:/^GA\d{1,5}$/', // Validates "GA" followed by 1 to 5 digits
                function($attribute, $value, $fail) {
                    // Custom validation to ensure only digits after "GA"
                    $digitsOnly = substr($value, 2); // Get the part after "GA"
                    if (!ctype_digit($digitsOnly)) {
                        $fail('Nomor penerbangan harus mengandung hanya angka setelah "GA".');
                    }
                }
            ],
            'rute_penerbangan' => 'required|string',
            'jam_penerbangan' => 'required|date_format:H:i',
        ]);
    
        // Data from the request
        $fullNomorPenerbangan = $request->nomor_penerbangan; // No need to prepend "GA" as it is already included
    
        // Simpan data ke database
        $penerbangan = new Penerbangan();
        $penerbangan->nomor_penerbangan = $fullNomorPenerbangan;
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
        // Validate the form data
        $request->validate([
            'nomor_penerbangan' => 'required|digits:3',  // Validates that the input is exactly 3 digits
            'rute_penerbangan' => 'required|string',
            'jam_penerbangan' => 'required|date_format:H:i',
        ]);

        // Find the existing record
        $penerbangan = Penerbangan::findOrFail($id);

        // Concatenate the prefix "GA" with the user's input
        $fullNomorPenerbangan = 'GA' . $request->nomor_penerbangan;

        // Update the fields with the new data
        $penerbangan->nomor_penerbangan = $fullNomorPenerbangan;
        $penerbangan->rute_penerbangan = $request->rute_penerbangan;
        $penerbangan->jam_penerbangan = $request->jam_penerbangan;

        // Save the changes to the database
        $penerbangan->save();

        // Redirect back to the list with a success message
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
