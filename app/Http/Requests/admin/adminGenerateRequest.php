<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class adminGenerateRequest extends FormRequest
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
            'id'=> 'required',
            'username'=> 'required',
            'username'=> 'required',
            'surname'=> 'required',
            'email'=> 'required',
            'tel'=> 'required',
            'password'=> 'required'
        ];
    }
}
