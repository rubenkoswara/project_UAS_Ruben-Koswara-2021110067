<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements Rule
{
    public function passes($attribute, $value)
    {
        if (app()->environment('local')) {
            return true;
        }

        $response = Http::withoutVerifying()
            ->asForm()
            ->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $value,
            ]);

        return (bool) ($response->json('success') ?? false);
    }

    public function message()
    {
        return 'The reCAPTCHA verification failed. Please try again.';
    }
}
