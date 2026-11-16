<?php
namespace Modules\Buku\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class BukuRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->role === 'admin'; }
    public function rules(): array { return ['judul'=>'required|string|max:200','penulis'=>'required|string|max:150','penerbit'=>'required|string|max:150','tahun_terbit'=>'required|integer|min:1000|max:'.(date('Y')+1),'stok'=>'required|integer|min:0']; }
}
