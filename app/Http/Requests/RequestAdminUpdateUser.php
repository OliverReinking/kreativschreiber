<?php

namespace App\Http\Requests;

use App\Rules\Language;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RequestAdminUpdateUser extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [];

        $rules['first_name'] = ['required', 'max:200'];
        $rules['last_name'] = ['required', 'max:200'];
        $rules['email'] = ['required', 'email', Rule::unique('users')->ignore($this->appuser->id)];
        $rules['is_admin'] = ['boolean'];
        $rules['is_customer'] = ['boolean'];

        return $rules;
    }
}
