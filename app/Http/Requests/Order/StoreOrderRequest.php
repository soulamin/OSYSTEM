<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'responsible_user_id' => ['nullable', 'integer', 'exists:users,id'],
            'status' => ['nullable', 'in:aberta,em_andamento,finalizada,cancelada'],
            'opened_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'solution' => ['nullable', 'string'],
            'signature_image' => ['nullable', 'string'],
            'services' => ['required', 'array', 'min:1'],
            'services.*.id' => ['required', 'integer', 'exists:services,id'],
            'services.*.quantity' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $status = (string) $this->input('status', '');
            $signature = (string) $this->input('signature_image', '');
            $solution = (string) $this->input('solution', '');

            if ($status === 'finalizada' && trim($signature) === '') {
                $validator->errors()->add('signature_image', 'Assinatura é obrigatória para finalizar a OS.');
            }

            if ($status === 'finalizada' && trim($solution) === '') {
                $validator->errors()->add('solution', 'Solução é obrigatória para finalizar a OS.');
            }

            if (trim($signature) !== '' && ! str_starts_with($signature, 'data:image/')) {
                $validator->errors()->add('signature_image', 'Formato de assinatura inválido.');
            }
        });
    }
}
