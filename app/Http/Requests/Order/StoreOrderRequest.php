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
            'category_id' => ['nullable', 'integer', 'exists:order_categories,id'],
            'client_name' => ['nullable', 'string', 'max:150'],
            'client_document' => ['nullable', 'string', 'max:30'],
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
            $clientName = trim((string) $this->input('client_name', ''));
            $clientDocument = preg_replace('/\D+/', '', (string) $this->input('client_document', ''));

            if ($status === 'finalizada' && trim($signature) === '') {
                $validator->errors()->add('signature_image', 'Assinatura é obrigatória para finalizar a OS.');
            }

            if ($status === 'finalizada' && trim($solution) === '') {
                $validator->errors()->add('solution', 'Solução é obrigatória para finalizar a OS.');
            }

            if ($status === 'finalizada' && $clientName === '') {
                $validator->errors()->add('client_name', 'Nome do cliente é obrigatório para finalizar a OS.');
            }

            if ($status === 'finalizada' && $clientDocument === '') {
                $validator->errors()->add('client_document', 'Documento é obrigatório para finalizar a OS.');
            }

            if ($clientDocument !== '' && ! preg_match('/^\d{11}$|^\d{14}$/', $clientDocument)) {
                $validator->errors()->add('client_document', 'Documento inválido.');
            }

            if (trim($signature) !== '' && ! str_starts_with($signature, 'data:image/')) {
                $validator->errors()->add('signature_image', 'Formato de assinatura inválido.');
            }
        });
    }
}
