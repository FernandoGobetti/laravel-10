<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'subject' => 'required|min:3|max:255|unique:supports',
            'body' => [
                'required', 'min:3', 'max:100000'
            ]
        ];

        if ($this->method() === 'PUT' || $this->method() === 'PATCH')
        {
            // $rules['subject'] = 'required|min:3|max:255|unique:supports,subject,{$this->id},id';

            $rules['subject'] = [
                'required',
                'min:3', 
                'max:255',
                Rule::unique('supports')->ignore($this->support ?? $this->id),
            ];
        }


        return $rules;
    }

    public function messages()
    {
        return [
            'subject.required' => 'O campo SUBJECT é obrigatório',
            'subject.min' => 'O campo SUBJECT precisa pelo menos :min caracteres',
            'body.required' => 'O campo BODY é obrigatório',
            'body.min' => 'O campo BODY precisa pelo menos :min caracteres',
        ];
    }
}
