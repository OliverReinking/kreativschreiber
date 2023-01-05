<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCreateContentAdvertising extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];

        $rules['offer'] = ['required', 'min:10', 'max:400'];
        $rules['interest_groups'] = ['nullable', 'min:5', 'max:400'];
        $rules['professional_groups'] = ['nullable', 'min:5', 'max:400'];
        $rules['lifestyle'] = ['nullable', 'min:5', 'max:400'];

        return $rules;
    }

    public function messages()
    {
        return [

            'offer.required'               => 'Die Beschreibung des Angebotes ist notwendig.',
            'offer.min'                    => 'Für die Beschreibung des Angebotes sind mindestens 10 Zeichen notwendig.',
            'offer.max'                    => 'Für die Beschreibung des Angebotes sind maximal 400 Zeichen erlaubt.',

            'interest_groups.min'          => 'Für die Beschreibung der Interessengruppen sind mindestens 5 Zeichen notwendig.',
            'interest_groups.max'          => 'Für die Beschreibung der Interessengruppen sind maximal 400 Zeichen erlaubt.',

            'professional_groups.min'      => 'Für die Beschreibung der Berufsgruppen sind mindestens 5 Zeichen notwendig.',
            'professional_groups.max'      => 'Für die Beschreibung der Berufsgruppen sind maximal 400 Zeichen erlaubt.',

            'lifestyle.min'                => 'Für die Beschreibung des Lifestyles sind mindestens 5 Zeichen notwendig.',
            'lifestyle.max'                => 'Für die Beschreibung des Lifestyles sind maximal 400 Zeichen erlaubt.',

        ];
    }
}
