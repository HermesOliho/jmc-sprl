<?php

use App\Models\User;

test('registration screen cannot be rendered when registration is disabled', function () {
    $response = $this->get('/register');

    $response->assertNotFound();
});

test('new users cannot register when registration is disabled', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertNotFound();
    $this->assertGuest();
    expect(User::query()->where('email', 'test@example.com')->exists())->toBeFalse();
});
