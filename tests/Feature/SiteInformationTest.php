<?php

beforeEach(function () {
    config()->set('inertia.testing.ensure_pages_exist', false);
});

test('les coordonnées officielles sont partagées avec les pages publiques', function () {
    $this->get('/contact')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('site.slogan', 'Building Progress, Moving Possibilities, Delivering Excellence')
            ->where('site.contact.email', 'contact@jmcservices.com')
            ->where('site.contact.website', 'https://www.jmcservices.com')
            ->where('site.contact.address.city', 'Durba')
            ->where('site.contact.address.province', 'Haut-Uélé')
            ->where('site.contact.address.country', 'République Démocratique du Congo')
            ->where('site.contact.phones.0.display', '+243 992 863 895')
            ->where('site.contact.phones.0.e164', '+243992863895')
            ->where('site.contact.phones.1.e164', '+243862386714')
            ->where('site.contact.phones.2.e164', '+256708752780')
            ->where('site.contact.whatsapp.url', 'https://wa.me/243980637512')
        )
        ->assertSee('contact@jmcservices.com', false)
        ->assertSee('Building Progress, Moving Possibilities, Delivering Excellence', false)
        ->assertSee('Durba', false)
        ->assertSee('"@type":"ContactPoint"', false);
});
