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
        ];
    }
}

