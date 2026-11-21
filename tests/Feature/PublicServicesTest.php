<?php

use App\Models\Service;
use Database\Seeders\ServiceSeeder;

beforeEach(function () {
    config()->set('inertia.testing.ensure_pages_exist', false);
});

test('la page services reçoit les services actifs dans le bon ordre', function () {
    $this->seed(ServiceSeeder::class);
    Service::factory()->create(['title' => 'Service inactif', 'is_active' => false]);

    $this->get('/services')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Public/Services')
            ->has('services', 16)
            ->where('services.0.slug', 'construction-generale')
            ->where('services.15.slug', 'renovation')
        );
});

test('l’accueil reçoit uniquement les services mis en avant', function () {
    $this->seed(ServiceSeeder::class);

    $this->get('/')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Public/Home')
            ->has('services', 9)
            ->where('services.0.slug', 'construction-generale')
            ->where('services.4.slug', 'renovation')
        );
});

test('la page contact reçoit la liste des services', function () {
    $this->seed(ServiceSeeder::class);

    $this->get('/contact')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Public/Contact')
            ->has('services', 16)
        );
});

test('le footer partagé contient les quatre premiers services', function () {
    $this->seed(ServiceSeeder::class);

    $this->get('/services')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('footer_services.0.slug', 'construction-generale')
            ->where('footer_services.1.slug', 'construction-metallique')
            ->where('footer_services.2.slug', 'travaux-publics')
            ->where('footer_services.3.slug', 'electricite-batiment')
            ->has('footer_services', 4)
        );
});

test('les anciennes urls de services redirigent vers les ancres', function () {
    $this->get('/services/soudure')->assertRedirect('/services#soudure');
});
