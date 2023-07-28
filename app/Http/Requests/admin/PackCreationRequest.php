<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class PackCreationRequest extends FormRequest
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
            'created_by' => 'required',
            'intitule' => 'required',
            'description' => 'required',
            'description_globale' => 'required',
            'prix' => 'required',
            'pourcentage' => 'required',
            'pourcentageReduction' => 'required',
            'imgUrl' => 'required'
        ];
    }
}
