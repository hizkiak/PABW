<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class KontakController extends Controller
{
    /**
     * READ: menampilkan daftar kontak.
     */
    public function index(): View
    {
        $kontaks = Kontak::latest()->paginate(5); // 5 data per halaman

        return view('kontaks.index', compact('kontaks'));
    }

    /**
     * CREATE: menampilkan form tambah kontak.
     */
    public function create(): View
    {
        return view('kontaks.create');
    }

    /**
     * CREATE: memvalidasi dan menyimpan kontak baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Foto opsional, maks. 2 MB
        ]);

        if ($request->hasFile('foto')) {
            // Simpan ke storage/app/public/foto_kontak, lalu simpan path-nya
            $validated['foto'] = $request->file('foto')->store('foto_kontak', 'public');
        }

        Kontak::create($validated);

        return redirect()->route('kontaks.index')->with('success', 'Kontak berhasil ditambahkan.');
    }

    /**
     * READ: menampilkan detail satu kontak.
     */
    public function show(Kontak $kontak): View
    {
        return view('kontaks.show', compact('kontak'));
    }

    /**
     * UPDATE: menampilkan form edit kontak.
     */
    public function edit(Kontak $kontak): View
    {
        return view('kontaks.edit', compact('kontak'));
    }

    /**
     * UPDATE: menyimpan perubahan (foto baru bersifat opsional).
     */
    public function update(Request $request, Kontak $kontak): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($kontak->foto) {
                Storage::disk('public')->delete($kontak->foto); // Hapus foto lama
            }
            $validated['foto'] = $request->file('foto')->store('foto_kontak', 'public');
        }

        $kontak->update($validated);

        return redirect()->route('kontaks.index')->with('success', 'Kontak berhasil diperbarui.');
    }

    /**
     * DELETE: menghapus file foto di storage dan data di database.
     */
    public function destroy(Kontak $kontak): RedirectResponse
    {
        if ($kontak->foto) {
            Storage::disk('public')->delete($kontak->foto); // Hapus file foto
        }
        $kontak->delete(); // Hapus data dari database

        return redirect()->route('kontaks.index')->with('success', 'Kontak berhasil dihapus.');
    }
}