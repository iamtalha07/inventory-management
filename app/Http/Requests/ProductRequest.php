<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' =>'required',
            'purchase_qty' => 'required|numeric|not_in:0',
            'purchase_rate' => 'required |numeric|not_in:0',
            'sale_rate'=> 'required|numeric|not_in:0',
            'ctn_size'=> 'numeric|not_in:0',
            'ctn_sale_rate'=> 'numeric|not_in:0',
        ];
        if(request()->id)
        {
            $rule['name'] = ['required'];
            $rule['purchase_qty'] = ['required','numeric','not_in:0'];
            $rule['purchase_rate'] = ['required','numeric','not_in:0'];
            $rule['sale_rate'] = ['required','numeric','not_in:0'];
            $rule['ctn_size'] = ['required','not_in:0'];
            $rule['ctn_sale_rate'] = ['required','not_in:0'];
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'purchase_qty.required' => 'The purchase quantity field is required.',
            'purchase_qty.numeric' => 'Please Enter Numeric Value',
            'purchase_qty.not_in' => 'Purchase quantity can not be 0',
            'purchase_rate.required' => 'The purchase rate field is required.',
            'purchase_rate.numeric' => 'Please Enter Numeric Value',
            'purchase_rate.not_in' => 'Purchase rate can not be 0',
            'sale_rate.required' => 'The sale rate field is required.',
            'sale_rate.numeric' => 'Please Enter Numeric Value',
            'sale_rate.not_in' => 'Sale rate can not be 0',
            'ctn_size.numeric' => 'Please Enter Numeric Value',
            'ctn_sale_rate.numeric' => 'Please Enter Numeric Value',

        ];
    }
}
