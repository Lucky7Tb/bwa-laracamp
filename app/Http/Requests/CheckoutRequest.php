<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],
            'occupation' => ['required', 'string'],
            'card_number' => ['required', 'integer'],
            'expired' => ['required', 'string', 'date_format:Y-m'],
            'cvc' => ['required', 'digits:3']
        ];
    }
}
