<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KelolaUserController extends Controller
{
    // Display Users Table
    public function index()
    {
        $users = User::paginate(10); // Adjust the number to how many users you want per page
        return view('kelola_user', compact('users'));
    }

    // Show the form for creating a new user
    public function create()
    {
        return view('users.create');
    }

    // Store a newly created user in storage
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Nama harus diisi.',
            'name.alpha' => 'Nama hanya boleh terdiri dari huruf.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password harus memiliki minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role harus dipilih.',
            'role.in' => 'Role tidak valid.',
        ];
    
        $request->validate([
            'name' => 'required|string|alpha|max:255', // Only letters allowed
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:Supervisor,Karyawan,Intern', // Add role validation
        ], $messages);
    
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
    
        $user->save();
    
        return redirect()->route('users.index')->with('pesan', 'Data Berhasil Ditambahkan');
    }
    // Show the form for editing the specified user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('edit_user', compact('user'));
    }

    // Update the specified user in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:Supervisor,Karyawan,Intern', // Add role validation
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('pesan', 'Data Berhasil Diedit');
    }

    // Remove the specified user from storage
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('pesan', 'Data Berhasil Dihapus.');
    }
}
