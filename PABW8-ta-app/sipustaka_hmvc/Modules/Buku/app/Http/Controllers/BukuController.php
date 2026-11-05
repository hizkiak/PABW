<?php

namespace Modules\Buku\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Buku\Http\Requests\BukuRequest;
use Modules\Buku\Models\Buku;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku dengan pencarian dan pagination.
     */
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $bukus = Buku::query()
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $query) use ($search) {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('penerbit', 'like', "%{$search}%");
                });
            })
            ->orderBy('judul')
            ->paginate(10)
            ->withQueryString();

        return view('buku::index', [
            'bukus' => $bukus,
            'search' => $search,
        ]);
    }

    /**
     * Menampilkan form tambah buku.
     */
    public function create(): View
    {
        return view('buku::create');
    }

    /**
     * Menyimpan buku baru.
     */
    public function store(BukuRequest $request): RedirectResponse
    {
        Buku::create($request->validated());

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit buku.
     */
    public function edit(Buku $buku): View
    {
        return view('buku::edit', [
            'buku' => $buku,
        ]);
    }

    /**
     * Memperbarui data buku.
     */
    public function update(
        BukuRequest $request,
        Buku $buku
    ): RedirectResponse {
        $buku->update($request->validated());

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * Menghapus data buku.
     */
    public function destroy(Buku $buku): RedirectResponse
    {
        $buku->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil dihapus.');
    }
}