<?php

use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;

test('le formulaire de contact envoie le message à l’adresse officielle', function () {
    Mail::fake();
    config()->set('mail.contact_to', 'contact@jmcservices.com');

    $response = $this->post('/contact', [
        'name' => 'Jean Mukendi',
        'company' => 'Entreprise Test',
        'email' => 'jean@example.com',
        'phone' => '+243 992 863 895',
        'subject' => 'devis',
        'message' => 'Bonjour, je souhaite obtenir un devis pour mon projet.',
        'consent' => true,
        'website' => '',
    ]);

    $response->assertRedirect();

    Mail::assertSent(ContactMessage::class, function (ContactMessage $mail): bool {
        return $mail->hasTo('contact@jmcservices.com')
            && $mail->hasReplyTo('jean@example.com');
    });
});

test('le formulaire de contact valide les champs obligatoires', function () {
    $response = $this->from('/contact')->post('/contact', [
        'name' => '',
        'email' => 'adresse-invalide',
        'subject' => 'inconnu',
        'message' => 'Court',
        'consent' => false,
    ]);

    $response->assertRedirect('/contact');
    $response->assertSessionHasErrors(['name', 'email', 'subject', 'message', 'consent']);
});

test('le honeypot silencieux ne bloque pas un message légitime', function () {
    Mail::fake();
    config()->set('mail.contact_to', 'contact@jmcservices.com');

    $this->post('/contact', [
        'name' => 'Jean Mukendi',
        'email' => 'jean@example.com',
        'subject' => 'information',
        'message' => 'Je souhaite obtenir des informations sur vos services.',
        'consent' => true,
        'website' => '',
    ])->assertRedirect();

    Mail::assertSent(ContactMessage::class);
});
