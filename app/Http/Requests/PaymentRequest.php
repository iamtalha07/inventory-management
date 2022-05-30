<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rule = [
            'date' => 'required|string',
            'paid_amount' => 'required|numeric'
        ];

        return $rule;
    }

    public function messages()
    {
        return [
            'required' => 'This field can not be empty',
            'numeric' => 'Please enter numeric value'
        ];
    }
}
