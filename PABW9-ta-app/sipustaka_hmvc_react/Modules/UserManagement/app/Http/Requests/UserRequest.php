<?php
namespace Modules\UserManagement\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UserRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->role === 'admin'; }
    public function rules(): array { $id=$this->route('user')?->id; return ['name'=>'required|string|max:255','email'=>'required|email|max:255|unique:users,email,'.$id,'password'=>($this->isMethod('post')?'required':'nullable').'|string|min:8','role'=>'required|in:admin,user']; }
}
