<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class RequestAdminStoreAndUpdateAcquisition extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];

        $rules['branch'] = ['required', 'max:100'];
        $rules['notes'] = ['nullable', 'max:400'];

        //Log::info('RequestAdminStoreAndUpdateAcquisition rules', [
        //    'this->id' => $this->id,
        //]);

        $rules['email'] = ['required', 'email', 'max:100', 'unique:acquisitions,email,' . $this->id];
        //
        return $rules;
    }

    public function messages()
    {
        return [
            'email.required' => 'Bitte gebe die Mailadresse ein.',
            'email.email' => 'Die vorgegebene Mailadresse ist keine gültige Mailadresse.',
            'email.max' => 'Für die Eingabe der Mailadresse stehen maximal 100 Zeichen zur Verfügung.',
            'email.unique' => 'Diese Mailadresse wurde bereits verwendet.',

            'branch.required' => 'Bitte gebe die Branche ein.',
            'branch.max' => 'Für die Eingabe der Branche stehen maximal 100 Zeichen zur Verfügung.',

            'notes.max' => 'Für die Eingabe einer stehen maximal 400 Zeichen zur Verfügung.',
        ];
    }
}
