<?php

use App\Models\User;

test('tamu dialihkan ke login saat membuka kelola user', function () {
    $response = $this->get('/admin/users');

    $response->assertRedirect('/login');
});

test('user biasa ditolak saat membuka kelola user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/admin/users');

    $response->assertStatus(403);
});

test('admin dapat melihat daftar user', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->get('/admin/users');

    $response->assertStatus(200);
});

test('admin dapat menambah user baru', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->post('/admin/users', [
        'name' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'role' => 'user',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/admin/users');
    $this->assertDatabaseHas('users', ['email' => 'budi@example.com']);
});

test('admin tidak dapat menghapus akunnya sendiri', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->delete("/admin/users/{$admin->id}");

    $response->assertRedirect('/admin/users');
    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});