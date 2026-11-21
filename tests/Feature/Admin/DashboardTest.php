<?php

use App\Models\User;

beforeEach(function () {
    config()->set('inertia.testing.ensure_pages_exist', false);
});

test('guests are redirected to the login page from the dashboard', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('authenticated users can visit the admin dashboard', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Dashboard')
            ->has('stats.users')
            ->has('stats.partners')
            ->has('stats.active_partners')
        );
});
