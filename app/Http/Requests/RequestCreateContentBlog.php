<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCreateContentBlog extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];

        $rules['topic'] = ['required', 'min:10', 'max:400'];
        $rules['interest_groups'] = ['nullable', 'min:5', 'max:400'];
        $rules['professional_groups'] = ['nullable', 'min:5', 'max:400'];
        $rules['lifestyle'] = ['nullable', 'min:5', 'max:400'];
        $rules['number_of_words'] = ['required', 'in:400,500,600,700,800,900'];

        return $rules;
    }

    public function messages()
    {
        return [

            'topic.required'               => 'Die Beschreibung des Themas ist notwendig.',
            'topic.min'                    => 'Für die Beschreibung des Themas sind mindestens 10 Zeichen notwendig.',
            'topic.max'                    => 'Für die Beschreibung des Themas sind maximal 400 Zeichen erlaubt.',

            'interest_groups.min'          => 'Für die Beschreibung der Interessengruppen sind mindestens 5 Zeichen notwendig.',
            'interest_groups.max'          => 'Für die Beschreibung der Interessengruppen sind maximal 400 Zeichen erlaubt.',

            'professional_groups.min'      => 'Für die Beschreibung der Berufsgruppen sind mindestens 5 Zeichen notwendig.',
            'professional_groups.max'      => 'Für die Beschreibung der Berufsgruppen sind maximal 400 Zeichen erlaubt.',

            'lifestyle.min'                => 'Für die Beschreibung des Lifestyles sind mindestens 5 Zeichen notwendig.',
            'lifestyle.max'                => 'Für die Beschreibung des Lifestyles sind maximal 400 Zeichen erlaubt.',

            'number_of_words.required'     => 'Die Angabe Anzahl der Wörter ist notwendig.',
            'number_of_words.in'           => 'Die Angabe Anzahl der Wörter muss 300, 400, 500, 600, 700, 800 oder 900 entsprechen.',

        ];
    }
}
