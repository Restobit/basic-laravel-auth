<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $rules = User::VALIDATION_RULES;
        $rules['email'][1] = 'unique:users,email,' . request()->route('user')->id;
        if (env('MUST_ACCEPT_USER_REGISTRATION')) {
            $rules += ['accepted' => 'required'];
        }
        return $rules;
    }
}
