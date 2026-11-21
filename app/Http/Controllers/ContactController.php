<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function store(ContactRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['website'])) {
            return back()->with('status', 'Votre message a bien été pris en compte.');
        }

        unset($data['website']);

        try {
            Mail::to(config('mail.contact_to'))->send(new ContactMessage($data));
        } catch (Throwable $exception) {
            Log::error('Contact form delivery failed.', [
                'exception' => $exception->getMessage(),
            ]);

            return back()
                ->withInput($request->safe()->except(['consent', 'website']))
                ->with('error', "L'envoi du message a échoué. Veuillez réessayer ou nous contacter par un autre moyen.");
        }

        return back()->with('status', 'Votre message a bien été transmis. Nous vous répondrons dès que possible.');
    }
}
