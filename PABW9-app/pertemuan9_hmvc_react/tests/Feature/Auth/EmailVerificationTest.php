<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

test('email verification routes are disabled', function () {
    expect(Route::has('verification.notice'))->toBeFalse();
    expect(Route::has('verification.verify'))->toBeFalse();
    expect(Route::has('verification.send'))->toBeFalse();
});

test('unverified users can access the dashboard without verification', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertOk();
});
