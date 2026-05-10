<?php

namespace App\Http\Requests\EmailSetting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $encryption = $this->input('encryption');
        $from = $this->input('from_address');
        $mailer = $this->input('mailer');

        $this->merge([
            'enabled' => filter_var($this->input('enabled'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false,
            'mailer' => $mailer !== null ? strtolower(trim((string) $mailer)) : 'smtp',
            'host' => $this->input('host') !== null ? trim((string) $this->input('host')) : null,
            'port' => $this->input('port') !== null ? (int) $this->input('port') : null,
            'username' => $this->input('username') !== null ? trim((string) $this->input('username')) : null,
            'encryption' => $encryption !== null && trim((string) $encryption) !== '' ? strtolower(trim((string) $encryption)) : null,
            'from_address' => $from !== null ? trim((string) $from) : null,
            'from_name' => $this->input('from_name') !== null ? trim((string) $this->input('from_name')) : null,
            'body_html' => $this->input('body_html') !== null && trim((string) $this->input('body_html')) !== ''
                ? (string) $this->input('body_html')
                : null,
            'body_html_opened' => $this->input('body_html_opened') !== null && trim((string) $this->input('body_html_opened')) !== ''
                ? (string) $this->input('body_html_opened')
                : null,
            'body_html_closed' => $this->input('body_html_closed') !== null && trim((string) $this->input('body_html_closed')) !== ''
                ? (string) $this->input('body_html_closed')
                : null,
        ]);
    }

    public function rules(): array
    {
        $enabled = (bool) $this->input('enabled', false);

        return [
            'enabled' => ['required', 'boolean'],
            'mailer' => ['required', 'string', 'in:smtp'],
            'host' => [$enabled ? 'required' : 'nullable', 'string', 'max:150'],
            'port' => [$enabled ? 'required' : 'nullable', 'integer', 'min:1', 'max:65535'],
            'username' => ['nullable', 'string', 'max:150'],
            'password' => ['nullable', 'string', 'max:255'],
            'encryption' => ['nullable', 'string', 'in:tls,ssl'],
            'from_address' => [$enabled ? 'required' : 'nullable', 'email', 'max:150'],
            'from_name' => ['nullable', 'string', 'max:150'],
            'body_html' => ['nullable', 'string'],
            'body_html_opened' => ['nullable', 'string'],
            'body_html_closed' => ['nullable', 'string'],
        ];
    }
}
