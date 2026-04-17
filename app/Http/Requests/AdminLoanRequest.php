<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'book_id' => ['required', 'exists:books,id'],
            'status' => ['required', 'in:pending,pinjam,rejected,kembali'],
            'expected_return_date' => ['required', 'date'],
            'expected_return_time' => ['required', 'date_format:H:i'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'nomor_hp' => ['nullable', 'string', 'max:20'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'User harus dipilih.',
            'user_id.exists' => 'User tidak ditemukan.',
            'book_id.required' => 'Buku harus dipilih.',
            'book_id.exists' => 'Buku tidak ditemukan.',
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status tidak valid.',
            'expected_return_date.required' => 'Tanggal pengembalian harus diisi.',
            'expected_return_date.date' => 'Tanggal pengembalian tidak valid.',
            'expected_return_time.required' => 'Waktu pengembalian harus diisi.',
            'expected_return_time.date_format' => 'Format waktu tidak valid. Gunakan HH:MM.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat terlalu panjang.',
            'nomor_hp.string' => 'Nomor HP harus berupa teks.',
            'nomor_hp.max' => 'Nomor HP terlalu panjang.',
        ];
    }
}

