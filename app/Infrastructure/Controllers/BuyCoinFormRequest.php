<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Foundation\Http\FormRequest;

class BuyCoinFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'coin_id' => 'required|string',
            'wallet_id' => 'required|string',
            'amount_usd' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'coin_id.required' => 'El campo coin_id es requerido.',
            'coin_id.string' => 'El campo coin_id debe ser un string.',
            'wallet_id.required' => 'El campo wallet_id es requerido.',
            'wallet_id.string' => 'El campo wallet_id debe ser un string.',
            'amount_usd.required' => 'El campo amount_usd es requerido.',
            'amount_usd.numeric' => 'El campo amount_usd debe ser un número.',
        ];
    }
}
