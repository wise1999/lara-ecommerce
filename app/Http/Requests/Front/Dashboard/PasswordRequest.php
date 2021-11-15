<?php

namespace App\Http\Requests\Front\Dashboard;

use App\Rules\MatchPasswords;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'current_password' => ['required', new MatchPasswords],
            'new_password' => ['required'],
            'new_password_confirm' => ['same:new_password'],
        ];
    }
}
