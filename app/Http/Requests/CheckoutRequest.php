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
        $expiredDateNow = date('Y-m', time());

        return [
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],
            'occupation' => ['required', 'string'],
            'phone_number' => ['required', 'digits_between:10,15'],
            'address' => ['required', 'string'],
            'code' => [
                'string',
                'max:5',
                'nullable', 
                Rule::exists('discounts', 'code')->where(function($query) {
                    return $query->where('deleted_at', null);
                })
            ]
        ];
    }
}
