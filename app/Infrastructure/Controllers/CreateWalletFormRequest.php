<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Foundation\Http\FormRequest;

class CreateWalletFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'El campo user_id es requerido.',
            'user_id.string' => 'El campo user_id debe ser un string.',
        ];
    }

}
