<?php

namespace Modules\Buku\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'penulis' => [
                'required',
                'string',
                'max:255',
            ],

            'penerbit' => [
                'required',
                'string',
                'max:255',
            ],

            'tahun_terbit' => [
                'required',
                'integer',
                'min:1900',
                'max:' . date('Y'),
            ],

            'stok' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul buku wajib diisi.',
            'penulis.required' => 'Nama penulis wajib diisi.',
            'penerbit.required' => 'Nama penerbit wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.min' => 'Tahun terbit minimal 1900.',
            'tahun_terbit.max' => 'Tahun terbit tidak boleh melebihi tahun sekarang.',
            'stok.required' => 'Stok buku wajib diisi.',
            'stok.min' => 'Stok buku tidak boleh kurang dari 0.',
        ];
    }
}