<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'document' => preg_replace('/\D+/', '', (string) $this->input('document')),
            'phone' => preg_replace('/\D+/', '', (string) $this->input('phone')),
            'zip' => preg_replace('/\D+/', '', (string) $this->input('zip')),
            'state' => strtoupper((string) $this->input('state')),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'document' => ['required', 'string', 'max:20', 'unique:clients,document'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255', 'unique:clients,email'],
            'zip' => ['required', 'string', 'max:20'],
            'street' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:20'],
            'complement' => ['nullable', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'size:2'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $doc = (string) $this->input('document');
            if (! preg_match('/^(\d{11}|\d{14})$/', $doc)) {
                $validator->errors()->add('document', 'CPF/CNPJ inválido.');
            }
        });
    }
}
