<?php

use App\Models\Album;

beforeEach(function () {
    config()->set('inertia.testing.ensure_pages_exist', false);
});

test('l’accueil expose les métadonnées SEO côté serveur', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('<title data-inertia>Accueil — JMC Services S.P.R.L</title>', false)
        ->assertSee('rel="canonical"', false)
        ->assertSee('og:image', false)
        ->assertSee('application/ld+json', false)
        ->assertSee('"@type":"Organization"', false);
});

test('le sitemap contient les pages publiques', function () {
    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertSee(url('/'))
        ->assertSee(url('/a-propos'))
        ->assertSee(url('/services'))
        ->assertSee(url('/album'))
        ->assertSee(url('/contact'));
});

test('le sitemap contient les albums publiés et exclut les brouillons', function () {
    $published = Album::factory()->published()->create(['slug' => 'album-publie']);
    $draft = Album::factory()->create(['slug' => 'album-brouillon']);

    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertSee(url('/album/'.$published->slug))
        ->assertDontSee(url('/album/'.$draft->slug));
});

test('les pages légales en attente de validation ne sont pas indexables', function () {
    $this->get('/mentions-legales')
        ->assertOk()
        ->assertSee('noindex, nofollow', false);
});

test('le sitemap exclut les pages noindex', function () {
    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertDontSee('/mentions-legales')
        ->assertDontSee('/politique-de-confidentialite');
});

test('les pages internes ne sont pas indexables', function () {
    $this->get('/login')
        ->assertOk()
        ->assertSee('noindex, nofollow', false);
});
