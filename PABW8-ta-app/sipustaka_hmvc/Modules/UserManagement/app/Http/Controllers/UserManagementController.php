<?php

namespace Modules\UserManagement\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\UserManagement\Http\Requests\UserManagementRequest;

class UserManagementController extends Controller
{
    public function index(): View
    {
        return view('usermanagement::index', ['users' => User::orderBy('name')->paginate(10)]);
    }

    public function create(): View { return view('usermanagement::create'); }

    public function store(UserManagementRequest $request): RedirectResponse
    {
        User::create($request->validated());
        return redirect()->route('usermanagement.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit(User $usermanagement): View
    {
        return view('usermanagement::edit', ['user' => $usermanagement]);
    }

    public function update(UserManagementRequest $request, User $usermanagement): RedirectResponse
    {
        $data = $request->validated();
        if (empty($data['password'])) unset($data['password']);
        if ($usermanagement->is(auth()->user()) && $data['role'] !== UserRole::Admin->value) {
            return back()->withErrors(['role' => 'Anda tidak dapat menurunkan role akun sendiri.'])->withInput();
        }
        $usermanagement->update($data);
        return redirect()->route('usermanagement.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroy(User $usermanagement): RedirectResponse
    {
        abort_if($usermanagement->is(auth()->user()), 403, 'Anda tidak dapat menghapus akun sendiri.');
        $usermanagement->delete();
        return redirect()->route('usermanagement.index')->with('success', 'Akun berhasil dihapus.');
    }
}
