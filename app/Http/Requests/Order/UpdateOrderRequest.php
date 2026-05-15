<?php

namespace App\Http\Requests\Order;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['sometimes', 'required', 'integer', 'exists:clients,id'],
            'category_id' => ['sometimes', 'nullable', 'integer', 'exists:order_categories,id'],
            'client_name' => ['sometimes', 'nullable', 'string', 'max:150'],
            'client_document' => ['sometimes', 'nullable', 'string', 'max:30'],
            'responsible_user_id' => ['sometimes', 'nullable', 'integer', 'exists:users,id'],
            'status' => ['sometimes', 'required', 'in:aberta,em_andamento,finalizada,cancelada'],
            'opened_at' => ['sometimes', 'required', 'date'],
            'notes' => ['sometimes', 'nullable', 'string'],
            'solution' => ['sometimes', 'nullable', 'string'],
            'signature_image' => ['sometimes', 'nullable', 'string'],
            'services' => ['sometimes', 'required', 'array', 'min:1'],
            'services.*.id' => ['required_with:services', 'integer', 'exists:services,id'],
            'services.*.quantity' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            /** @var Order $order */
            $order = $this->route('order');

            if (! $this->has('status')) {
                return;
            }

            $newStatus = (string) $this->input('status', '');
            $signature = (string) $this->input('signature_image', '');
            $solution = (string) $this->input('solution', '');
            $clientName = trim((string) $this->input('client_name', ''));
            $clientDocumentRaw = (string) $this->input('client_document', '');
            $clientDocument = preg_replace('/\D+/', '', $clientDocumentRaw);

            if ($newStatus === Order::STATUS_FINALIZADA && $order->status !== Order::STATUS_FINALIZADA) {
                $alreadySigned = trim((string) $order->signature_image) !== '';
                if (! $alreadySigned && trim($signature) === '') {
                    $validator->errors()->add('signature_image', 'Assinatura é obrigatória para finalizar a OS.');
                }

                $alreadySolved = trim((string) $order->solution) !== '';
                if (! $alreadySolved && trim($solution) === '') {
                    $validator->errors()->add('solution', 'Solução é obrigatória para finalizar a OS.');
                }

                $storedClientName = trim((string) $order->client_name);
                if ($storedClientName === '' && $clientName === '') {
                    $validator->errors()->add('client_name', 'Nome do cliente é obrigatório para finalizar a OS.');
                }

                $storedClientDocument = preg_replace('/\D+/', '', (string) $order->client_document);
                if ($storedClientDocument === '' && $clientDocument === '') {
                    $validator->errors()->add('client_document', 'Documento é obrigatório para finalizar a OS.');
                }
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
