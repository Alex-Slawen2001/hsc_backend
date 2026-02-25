<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Message' => ['required','string','max:5000'],
            'Name' => ['required','string','max:255'],
            'Email' => ['nullable','email','max:255'],
            'Phone' => ['nullable','string','max:50'],
            'Company' => ['nullable','string','max:255'],
        ];
    }
}
