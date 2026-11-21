<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $subjects = array_column(config('site.contact_subjects', []), 'value');

        return [
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['required', 'string', Rule::in($subjects)],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'consent' => ['accepted'],
            'website' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Veuillez indiquer votre nom.',
            'email.required' => 'Veuillez indiquer votre adresse e-mail.',
            'email.email' => 'Veuillez indiquer une adresse e-mail valide.',
            'subject.required' => 'Veuillez choisir un sujet.',
            'subject.in' => 'Veuillez choisir un sujet valide.',
            'message.required' => 'Veuillez écrire votre message.',
            'message.min' => 'Votre message doit contenir au moins 10 caractères.',
            'consent.accepted' => 'Vous devez accepter le traitement de vos données.',
        ];
    }
}
