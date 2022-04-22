<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|max:255',
            'password' => 'required',
            'password_confirmation' => 'required',
            'employee_id' => 'required',
            'mobile' => 'required',
            'country' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'address' => 'required',
            'action_id' => 'required',
        ];
    }
}
