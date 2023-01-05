<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCreateChat extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];

        $rules['content'] = ['required', 'max:400'];

        return $rules;
    }

    public function messages()
    {
        return [

            'content.required'                  => 'Die Eingabe der Nachricht ist notwendig.',
            'content.max'                       => 'Für die Eingabe der Nachricht sind maximal 400 Zeichen erlaubt.',
        ];
    }
}
