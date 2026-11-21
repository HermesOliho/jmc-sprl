<?php

use App\Models\Partner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    config()->set('inertia.testing.ensure_pages_exist', false);
    Storage::fake('public');
    config()->set('media-library.disk_name', 'public');
});

test('authenticated users can view the partners list', function () {
    $user = adminUser();
    Partner::factory()->count(2)->create();

    $this->actingAs($user)
        ->get(route('admin.partners.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Partners/Index')
            ->has('partners', 2)
        );
});

test('authenticated users can create a partner with a logo', function () {
    $user = adminUser();

    $response = $this->actingAs($user)->post(route('admin.partners.store'), [
        'name' => 'Partenaire Test',
        'description' => 'Description courte',
        'website_url' => 'https://example.org',
        'is_active' => true,
        'sort_order' => 3,
        'logo' => UploadedFile::fake()->image('logo.png', 120, 80),
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.partners.index'));

    $partner = Partner::query()->where('name', 'Partenaire Test')->first();

    expect($partner)->not->toBeNull();
    expect($partner->description)->toBe('Description courte');
    expect($partner->website_url)->toBe('https://example.org');
    expect($partner->is_active)->toBeTrue();
    expect($partner->sort_order)->toBe(3);
    expect($partner->getFirstMedia('logo'))->not->toBeNull();
});

test('authenticated users can update a partner', function () {
    $user = adminUser();
    $partner = Partner::factory()->create([
        'name' => 'Ancien',
        'is_active' => true,
    ]);
    $partner->addMedia(UploadedFile::fake()->image('old.png', 120, 80))
        ->usingFileName('old.png')
        ->toMediaCollection('logo');

    $response = $this->actingAs($user)->post(route('admin.partners.update', $partner), [
        '_method' => 'put',
        'name' => 'Nouveau',
        'description' => 'Nouvelle description',
        'website_url' => 'https://nouveau.example',
        'is_active' => false,
        'sort_order' => 7,
        'logo' => UploadedFile::fake()->image('new.png', 120, 80),
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.partners.index'));

    $partner->refresh();

    expect($partner->name)->toBe('Nouveau');
    expect($partner->description)->toBe('Nouvelle description');
    expect($partner->website_url)->toBe('https://nouveau.example');
    expect($partner->is_active)->toBeFalse();
    expect($partner->sort_order)->toBe(7);
    expect($partner->getFirstMedia('logo'))->not->toBeNull();
});

test('authenticated users can delete a partner', function () {
    $user = adminUser();
    $partner = Partner::factory()->create();

    $response = $this->actingAs($user)->delete(route('admin.partners.destroy', $partner));

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.partners.index'));

    expect(Partner::query()->find($partner->id))->toBeNull();
});

test('home page displays only active partners with logos in order', function () {
    $inactive = Partner::factory()->inactive()->create(['name' => 'Inactif', 'sort_order' => 0]);
    $inactive->addMedia(UploadedFile::fake()->image('inactive.png', 120, 80))
        ->usingFileName('inactive.png')
        ->toMediaCollection('logo');

    $second = Partner::factory()->create(['name' => 'Second', 'sort_order' => 2, 'is_active' => true]);
    $second->addMedia(UploadedFile::fake()->image('second.png', 120, 80))
        ->usingFileName('second.png')
        ->toMediaCollection('logo');

    $first = Partner::factory()->create(['name' => 'Premier', 'sort_order' => 1, 'is_active' => true]);
    $first->addMedia(UploadedFile::fake()->image('first.png', 120, 80))
        ->usingFileName('first.png')
        ->toMediaCollection('logo');

    $withoutLogo = Partner::factory()->create(['name' => 'Sans logo', 'sort_order' => 0, 'is_active' => true]);

    $this->get('/')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Public/Home')
            ->has('partners', 2)
            ->where('partners.0.name', 'Premier')
            ->where('partners.1.name', 'Second')
        );
});
