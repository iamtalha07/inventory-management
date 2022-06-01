<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:5',
            'confirm_password' => 'required|min:5|same:password',
            'contact' => 'nullable|min:11',
            'salary' => 'nullable|numeric',
            'role_as' => 'required'
        ];
        if(request()->isMethod('put'))
        {   
            $rule['email'] = ['nullable'];
            $rule['password'] = ['nullable','min:5'];
            $rule['confirm_password'] = ['nullable','min:5','same:password'];
            $rule['contact'] = ['nullable','min:11'];
            $rule['salary'] = ['nullable','numeric'];
            $rule['role_as'] = ['required'];
        }
        return $rule;
    }
}
