<?php

use App\Models\Service;
use Database\Seeders\ServiceSeeder;

beforeEach(function () {
    config()->set('inertia.testing.ensure_pages_exist', false);
});

test('le seeder des services est idempotent et remplit tout le catalogue', function () {
    $this->seed(ServiceSeeder::class);
    $this->seed(ServiceSeeder::class);

    expect(Service::count())->toBe(16);

    $slugs = Service::ordered()->pluck('slug')->all();

    expect($slugs)->toBe([
        'construction-generale',
        'construction-metallique',
        'travaux-publics',
        'electricite-batiment',
        'production-de-materiaux',
        'fourniture-materiaux-construction',
        'travaux-miniers',
        'adduction-eau-potable',
        'soudure',
        'consultance',
        'peinture',
        'commerce-de-pieces',
        'transport-logistique',
        'agro-pastoral',
        'boulangerie-patisserie',
        'renovation',
    ]);

    expect(Service::featured()->count())->toBe(9);

    $featured = Service::featured()->homeOrdered()->pluck('slug')->all();

    expect($featured)->toBe([
        'construction-generale',
        'construction-metallique',
        'electricite-batiment',
        'travaux-publics',
        'renovation',
        'consultance',
        'fourniture-materiaux-construction',
        'transport-logistique',
        'boulangerie-patisserie',
    ]);

    $service = Service::query()->where('slug', 'transport-logistique')->firstOrFail();

    expect($service->title)->toBe('Transport & Logistique');
    expect($service->deliverables)->not->toBeEmpty();
    expect($service->benefits)->not->toBeEmpty();
    expect($service->is_active)->toBeTrue();
});

test('le seeder ne réécrase pas les modifications du back-office', function () {
    $this->seed(ServiceSeeder::class);

    $service = Service::query()->where('slug', 'soudure')->firstOrFail();
    $service->update(['title' => 'Titre personnalisé']);

    $this->seed(ServiceSeeder::class);

    expect(Service::count())->toBe(16);
    expect($service->fresh()->title)->toBe('Titre personnalisé');
});
