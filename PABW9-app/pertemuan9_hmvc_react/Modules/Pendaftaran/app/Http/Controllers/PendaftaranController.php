<?php

namespace Modules\Pendaftaran\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Pendaftaran\Http\Requests\DaftarRequest;
use Modules\Pendaftaran\Models\Daftar;

class PendaftaranController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Pendaftaran::index');
    }

    public function getData(): JsonResponse
    {
        return response()->json(Daftar::latest()->get());
    }

    public function store(DaftarRequest $request): JsonResponse
    {
        $data = $request->safe()->except('berkas');
        $file = $request->file('berkas');
        $data['berkas'] = $file->store('berkas_pendaftaran', 'public');
        $data['nama_berkas'] = $file->getClientOriginalName();

        Daftar::create($data);

        return response()->json(['success' => 'Data berhasil disimpan.']);
    }

    public function edit(Daftar $daftar): JsonResponse
    {
        return response()->json($daftar);
    }

    public function update(DaftarRequest $request, Daftar $daftar): JsonResponse
    {
        $data = $request->safe()->except('berkas');

        if ($request->hasFile('berkas')) {
            if ($daftar->berkas) {
                Storage::disk('public')->delete($daftar->berkas);
            }
            $file = $request->file('berkas');
            $data['berkas'] = $file->store('berkas_pendaftaran', 'public');
            $data['nama_berkas'] = $file->getClientOriginalName();
        }

        $daftar->update($data);

        return response()->json(['success' => 'Data berhasil diperbarui.']);
    }

    public function destroy(Daftar $daftar): JsonResponse
    {
        if ($daftar->berkas) {
            Storage::disk('public')->delete($daftar->berkas);
        }

        $daftar->delete();

        return response()->json(['success' => 'Data berhasil dihapus.']);
    }
}
