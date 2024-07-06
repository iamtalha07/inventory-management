<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LedgerRequest extends FormRequest
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
        return [
            'brand_id'      => 'required',
            'category_id'   => 'required',
            'bill_no'       => 'required',
            'bill_date'     => 'required',
            'billed_amount' => 'required|numeric',
            'amount_paid'   => 'required|numeric',
            'balance'       => 'required|numeric',
            'payment_date'  =>  'required',
        ];
    }

    public function messages()
    {
        return [
            '*.required'    =>  ':attribute is required',
            '*.numeric'     =>  ':attribute should be numeric',
        ];
    }

    public function attributes()
    {
        return [
            'brand_id'          => 'Brand',
            'category_id'       => 'Category',
            'bill_no'           => 'Bill Number',
            'description'       => 'Description',
            'bill_date'         => 'Bill Date',
            'billed_amount'     => 'Billed Amount',
            'amount_paid'       => 'Amount Paid',
            'balance'           => 'Balance',
            'payment_date'      => 'Payment Date',
        ];
    }
}
