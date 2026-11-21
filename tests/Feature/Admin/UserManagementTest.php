<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    config()->set('inertia.testing.ensure_pages_exist', false);
    Role::findOrCreate('admin', 'web');
});

test('authenticated users can view the users list', function () {
    $admin = adminUser();
    $users = User::factory()->count(2)->create();

    $this->actingAs($admin)
        ->get(route('admin.users.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Users/Index')
            ->has('users', 3)
        );
});

test('authenticated users can create a user', function () {
    $admin = adminUser();

    $response = $this->actingAs($admin)->post(route('admin.users.store'), [
        'name' => 'Nouvel Utilisateur',
        'email' => 'nouveau@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'is_admin' => false,
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.users.index'));

    $user = User::query()->where('email', 'nouveau@example.com')->first();

    expect($user)->not->toBeNull();
    expect($user->name)->toBe('Nouvel Utilisateur');
    expect($user->hasVerifiedEmail())->toBeTrue();
    expect($user->hasRole('admin'))->toBeFalse();
});

test('authenticated users can create an admin user', function () {
    $admin = adminUser();

    $this->actingAs($admin)->post(route('admin.users.store'), [
        'name' => 'Admin Créé',
        'email' => 'admin-cree@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'is_admin' => true,
    ])->assertSessionHasNoErrors();

    $user = User::query()->where('email', 'admin-cree@example.com')->firstOrFail();

    expect($user->hasRole('admin'))->toBeTrue();
});

test('authenticated users can update a user', function () {
    $admin = adminUser();
    $user = User::factory()->create([
        'name' => 'Ancien Nom',
        'email' => 'ancien@example.com',
    ]);

    $response = $this->actingAs($admin)->put(route('admin.users.update', $user), [
        'name' => 'Nouveau Nom',
        'email' => 'modifie@example.com',
        'password' => '',
        'password_confirmation' => '',
        'is_admin' => true,
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.users.index'));

    $user->refresh();

    expect($user->name)->toBe('Nouveau Nom');
    expect($user->email)->toBe('modifie@example.com');
    expect($user->hasRole('admin'))->toBeTrue();
});

test('users cannot remove their own admin access from the admin panel', function () {
    $admin = adminUser();
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->put(route('admin.users.update', $admin), [
        'name' => $admin->name,
        'email' => $admin->email,
        'password' => '',
        'password_confirmation' => '',
        'is_admin' => false,
    ]);

    $response
        ->assertRedirect(route('admin.users.edit', $admin))
        ->assertSessionHas('error');

    expect($admin->fresh()->hasRole('admin'))->toBeTrue();
});

test('authenticated users can delete another user', function () {
    $admin = adminUser();
    $user = User::factory()->create();

    $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $user));

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.users.index'));

    expect(User::query()->find($user->id))->toBeNull();
});

test('users cannot delete their own account from the admin panel', function () {
    $admin = adminUser();

    $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

    $response->assertForbidden();
    expect(User::query()->find($admin->id))->not->toBeNull();
});
