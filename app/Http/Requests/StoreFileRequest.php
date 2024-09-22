<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
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
        return [
            'path' => [
                'required',
                'string',
            ],
            'name' => [
                'required',
                'string',
            ],
            'subject' => [
                'required',
                'string',
                'max:255'
            ],
            'date' => [
                'required',
                'date',
            ],
         
            'refrence_number' => [
                'required',
                'string',
            ],
            'mime' => [
                'required',
                'string',
            ],
            'size' => [
                'required',
                'numeric',
            ],
            'redirect' => 'boolean',
          
          
        ];
    }
    public function messages()
    {
        return [
            'path.required' => 'Please select file.'
        ];
    }
}
