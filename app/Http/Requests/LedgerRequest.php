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
            'brand_id' => 'required',
            'bill_no' => 'required',
            'products' => 'required',
            'bill_date' => 'required',
            'total_amount' => 'required|numeric',
            'amount_paid' => 'required|numeric',
            'amount_remaining' => 'required|numeric',
            'payable_by' => 'required',
            'payable_to' => 'required',
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
            'brand_id'          => 'Brand ID',
            'bill_no'           => 'Bill Number',
            'products'          => 'Products',
            'bill_date'         => 'Bill Date',
            'total_amount'      => 'Total Amount',
            'amount_paid'       => 'Amount Paid',
            'amount_remaining'  => 'Amount Remaining',
            'payable_by'        => 'Payable By',
            'payable_to'        => 'Payable To',
            'remarks'           => 'Remarks',
        ];
    }
}
