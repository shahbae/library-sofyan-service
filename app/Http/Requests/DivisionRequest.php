<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DivisionRequest extends FormRequest
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
            'name_divisi' => 'required|string|max:255',
            'name_pic' => 'required|string|max:255',
        ];
    }

        /**
     * Customize the error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name_divisi.required' => 'Nama divisi harus diisi.',
            'name_pic.required' => 'Nama PIC harus diisi.',
        ];
    }
}
