<?php

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    config()->set('inertia.testing.ensure_pages_exist', false);
    Storage::fake('public');
    config()->set('media-library.disk_name', 'public');
});

test('les administrateurs voient la liste des services', function () {
    $user = adminUser();
    Service::factory()->count(2)->create();

    $this->actingAs($user)
        ->get(route('admin.services.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Services/Index')
            ->has('services', 2)
        );
});

test('les non-admins ne peuvent pas gérer les services', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.services.index'))
        ->assertForbidden();
});

test('les administrateurs peuvent créer un service avec cover', function () {
    $user = adminUser();

    $response = $this->actingAs($user)->post(route('admin.services.store'), [
        'title' => 'Nouveau service',
        'slug' => 'nouveau-service',
        'description' => 'Description du nouveau service.',
        'icon' => 'building2',
        'deliverables' => ['Prestation une', 'Prestation deux'],
        'benefits' => ['Avantage un'],
        'is_active' => true,
        'is_featured' => true,
        'sort_order' => 3,
        'home_sort_order' => 1,
        'cover' => UploadedFile::fake()->image('cover.jpg', 1200, 675),
        'image_alt' => 'Image du service',
        'image_position' => 'top',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.services.index'));

    $service = Service::query()->where('slug', 'nouveau-service')->first();

    expect($service)->not->toBeNull();
    expect($service->title)->toBe('Nouveau service');
    expect($service->deliverables)->toBe(['Prestation une', 'Prestation deux']);
    expect($service->benefits)->toBe(['Avantage un']);
    expect($service->is_featured)->toBeTrue();
    expect($service->image_position)->toBe('top');
    expect($service->getFirstMedia('cover'))->not->toBeNull();
});

test('le slug est généré depuis le titre quand il est vide', function () {
    $user = adminUser();

    $this->actingAs($user)->post(route('admin.services.store'), [
        'title' => 'Service Sans Slug',
        'description' => 'Description.',
        'icon' => 'globe',
    ])->assertSessionHasNoErrors();

    expect(Service::query()->where('slug', 'service-sans-slug')->exists())->toBeTrue();
});

test('la validation rejette un slug en double et une icône invalide', function () {
    $user = adminUser();
    Service::factory()->create(['slug' => 'doublon']);

    $this->actingAs($user)->post(route('admin.services.store'), [
        'title' => 'Titre',
        'slug' => 'doublon',
        'description' => 'Description.',
        'icon' => 'icon invalide !',
    ])->assertSessionHasErrors(['slug', 'icon']);
});

test('les administrateurs peuvent mettre à jour un service', function () {
    $user = adminUser();
    $service = Service::factory()->create([
        'title' => 'Ancien titre',
        'slug' => 'ancien-titre',
        'is_active' => true,
    ]);
    $service->addMedia(UploadedFile::fake()->image('old.jpg', 1200, 675))
        ->usingFileName('old.jpg')
        ->toMediaCollection('cover');

    $response = $this->actingAs($user)->post(route('admin.services.update', $service), [
        '_method' => 'put',
        'title' => 'Nouveau titre',
        'description' => 'Nouvelle description.',
        'icon' => 'truck',
        'deliverables' => ['Nouvelle prestation'],
        'benefits' => [],
        'is_active' => false,
        'is_featured' => true,
        'sort_order' => 7,
        'home_sort_order' => 2,
        'cover' => UploadedFile::fake()->image('new.jpg', 1200, 675),
        'image_alt' => 'Nouvelle image',
        'image_position' => 'bottom',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('admin.services.index'));

    $service->refresh();

    expect($service->title)->toBe('Nouveau titre');
    expect($service->slug)->toBe('ancien-titre');
    expect($service->is_active)->toBeFalse();
    expect($service->is_featured)->toBeTrue();
    expect($service->getFirstMedia('cover'))->not->toBeNull();
});

test('les administrateurs peuvent supprimer un service', function () {
    $user = adminUser();
    $service = Service::factory()->create();

    $response = $this->actingAs($user)->delete(route('admin.services.destroy', $service));

    $response->assertRedirect(route('admin.services.index'));

    expect(Service::query()->whereKey($service->id)->exists())->toBeFalse();
});
