<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnggotaRequest extends FormRequest
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
        $id = $this->route('anggotum');
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:anggota,email,'. $id,
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'status_anggota' => 'required|in:aktif,tidak aktif',
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
            'nama.required' => 'Nama anggota harus diisi.',
            'email.required' => 'Email anggota harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'Nomor HP anggota harus diisi.',
            'alamat.required' => 'Alamat anggota harus diisi.',
            'status_anggota.required' => 'Status anggota harus dipilih.',
        ];
    }
}
