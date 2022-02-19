<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'customer_name' =>'required|string',
            'booker_id' => 'required|string',
            'salesman_name' => 'required |string',
            
            'product_id' => 'required|not_in:0',
        ];
        return $rule;
    }

    public function messages()
    {
        return [
            'customer_name.required' => 'Customer name is required',
            'booker_name.required' => 'Booker name is required',
            'salesman_name.required' => 'Salesman name is required',
            'product_id.required' => 'Please select a product',
        ];
    }
}
