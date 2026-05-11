<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Menampilkan daftar Petugas/Satpam
    public function index()
    {
        // Hanya menampilkan user dengan role 'petugas'
        $penggunas = User::where('role', 'petugas')->get();
        return view('pengguna.index', compact('penggunas'));
    }

    // Menampilkan form tambah petugas
    public function create()
    {
        return view('pengguna.create');
    }

    // Menyimpan data petugas ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password langsung dienkripsi (Hash)
            'role' => 'petugas' // Langsung dikunci sebagai petugas
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Akun Petugas berhasil didaftarkan!');
    }

    // Menampilkan form edit petugas
    public function edit($id)
    {
        $pengguna = User::findOrFail($id);
        return view('pengguna.edit', compact('pengguna'));
    }

    // Menyimpan perubahan data petugas
    public function update(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id_pengguna',
            'password' => 'nullable|string|min:6'
        ]);

        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
        ];

        // Update password hanya jika diisi
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        return redirect()->route('pengguna.index')->with('success', 'Data Petugas berhasil diperbarui!');
    }

    // Menghapus akun petugas
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('pengguna.index')->with('success', 'Akun Petugas berhasil dihapus!');
    }
}