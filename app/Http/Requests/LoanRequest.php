<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'expected_return_date' => ['required', 'date', 'after:today'],
            'expected_return_time' => ['required', 'date_format:H:i'],
            'alamat' => ['required', 'string', 'max:500'],
            'nomor_hp' => ['required', 'string', 'size:12', 'regex:/^08[0-9]{10}$/'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'expected_return_date.required' => 'Tanggal pengembalian harus diisi.',
            'expected_return_date.date' => 'Tanggal pengembalian tidak valid.',
            'expected_return_date.after' => 'Tanggal pengembalian harus setelah hari ini.',
            'expected_return_time.required' => 'Waktu pengembalian harus diisi.',
            'expected_return_time.date_format' => 'Format waktu tidak valid. Gunakan HH:MM.',
            'alamat.required' => 'Alamat lengkap harus diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat terlalu panjang (maksimal 500 karakter).',
            'nomor_hp.required' => 'Nomor HP harus diisi.',
            'nomor_hp.size' => 'Nomor HP harus tepat 12 digit.',
            'nomor_hp.regex' => 'Nomor HP harus diawali 08 dan hanya boleh berisi angka.',
        ];
    }
}

