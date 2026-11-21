<?php

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
        ->assertSee(url('/contact'));
});

test('les pages internes ne sont pas indexables', function () {
    $this->get('/login')
        ->assertOk()
        ->assertSee('noindex, nofollow', false);
});
