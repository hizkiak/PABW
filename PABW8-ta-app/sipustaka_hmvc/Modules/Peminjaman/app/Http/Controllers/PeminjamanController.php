<?php

namespace Modules\Peminjaman\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Peminjaman\Models\Peminjaman;
use Modules\Peminjaman\Http\Requests\PeminjamanRequest;

class PeminjamanController extends Controller
{
    private function visiblePeminjamans()
    {
        return Peminjaman::query()
            ->when(!auth()->user()->isAdmin(), fn ($query) => $query->where('user_id', auth()->id()));
    }

    public function index()
    {
        $peminjamans = $this->visiblePeminjamans()->with('user')
            ->latest()
            ->paginate(10);

        return view('peminjaman::index', compact('peminjamans'));
    }

    public function data()
    {
        $data = $this->visiblePeminjamans()->with('user')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function store(PeminjamanRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('bukti')) {
            $validated['bukti'] = $request->file('bukti')
                ->store('bukti-peminjaman', 'public');
        }

        $peminjaman = Peminjaman::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data peminjaman berhasil ditambahkan.',
            'data' => $peminjaman
        ], 201);
    }

    public function show($id)
    {
        $peminjaman = $this->visiblePeminjamans()->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $peminjaman
        ]);
    }

    public function update(PeminjamanRequest $request, $id)
    {
        $peminjaman = $this->visiblePeminjamans()->findOrFail($id);

        $validated = $request->validated();

        if ($request->hasFile('bukti')) {

            if ($peminjaman->bukti) {
                Storage::disk('public')->delete($peminjaman->bukti);
            }

            $validated['bukti'] = $request->file('bukti')
                ->store('bukti-peminjaman', 'public');
        }

        unset($validated['user_id']);

        $peminjaman->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data peminjaman berhasil diperbarui.',
            'data' => $peminjaman
        ]);
    }

    public function destroy($id)
    {
        $peminjaman = $this->visiblePeminjamans()->findOrFail($id);

        if ($peminjaman->bukti) {
            Storage::disk('public')->delete($peminjaman->bukti);
        }

        $peminjaman->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data peminjaman berhasil dihapus.'
        ]);
    }
}
