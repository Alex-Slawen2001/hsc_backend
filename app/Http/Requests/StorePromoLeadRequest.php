<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromoLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Name' => ['required','string','max:255'],
            'Phone' => ['required','string','max:50'],
            'Email' => ['nullable','email','max:255'],
            'Model' => ['nullable','string','max:255'],
            'Message' => ['nullable','string','max:5000'],
            'Base' => ['nullable','integer','min:0'],
            'Extra' => ['nullable','integer','min:0'],
        ];
    }
}
