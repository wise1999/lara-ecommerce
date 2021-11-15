<?php

namespace App\Http\Requests\Front\Dashboard\Address;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'country' => 'required',
            'address_1' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
        ];
    }
}
