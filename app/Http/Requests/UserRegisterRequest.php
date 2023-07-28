<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'username' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'tel' => 'required',
            'role'=> 'required',
            'password' => 'required',
            'hasSuscribed' => 'required',
            'tmp_parent_ID' => 'required',
            'parent_ID' => 'required',
            'grandParent1_ID' => 'required',
            'grandParent2_ID' => 'required',

        ];
    }
}
