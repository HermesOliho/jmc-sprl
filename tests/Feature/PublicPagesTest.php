<?php

use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    config()->set('inertia.testing.ensure_pages_exist', false);
});

test('les pages publiques répondent et affichent l’identité JMC', function (string $uri, string $component) {
    $this->get($uri)
        ->assertOk()
        ->assertSee('JMC Services S.P.R.L')
        ->assertDontSee('Congo Construction')
        ->assertInertia(fn (Assert $page) => $page->component($component));
})->with([
    ['/', 'Public/Home'],
    ['/a-propos', 'Public/About'],
    ['/services', 'Public/Services'],
    ['/album', 'Public/Album/Index'],
    ['/contact', 'Public/Contact'],
    ['/mentions-legales', 'Public/LegalNotice'],
    ['/politique-de-confidentialite', 'Public/PrivacyPolicy'],
]);

test('les anciennes entrées de navigation sont redirigées', function (string $from, string $to) {
    $this->get($from)->assertRedirect($to);
})->with([
    ['/demande-devis', '/contact?subject=devis'],
    ['/realisations', '/services'],
    ['/carrieres', '/contact?subject=stage'],
    ['/actualites', '/a-propos'],
]);

test('une page inconnue renvoie une page 404', function () {
    $this->get('/page-inexistante')
        ->assertNotFound()
        ->assertInertia(fn (Assert $page) => $page->component('Errors/NotFound'));
});
