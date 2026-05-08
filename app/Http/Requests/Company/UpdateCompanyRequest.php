<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $cnpj = $this->input('cnpj');
        $zip = $this->input('zip');
        $state = $this->input('state');

        $this->merge([
            'cnpj' => $cnpj !== null ? preg_replace('/\D+/', '', (string) $cnpj) : null,
            'zip' => $zip !== null ? preg_replace('/\D+/', '', (string) $zip) : null,
            'state' => $state !== null ? strtoupper(trim((string) $state)) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'cnpj' => ['required', 'string', 'regex:/^\d{14}$/'],
            'logo_image' => ['nullable', 'string', 'starts_with:data:image/'],

            'zip' => ['required', 'string', 'regex:/^\d{8}$/'],
            'street' => ['required', 'string', 'max:150'],
            'number' => ['required', 'string', 'max:30'],
            'complement' => ['nullable', 'string', 'max:80'],
            'district' => ['required', 'string', 'max:80'],
            'city' => ['required', 'string', 'max:80'],
            'state' => ['required', 'string', 'size:2'],

            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
        ];
    }
}

