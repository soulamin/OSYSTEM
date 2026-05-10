<?php

namespace App\Services;

use App\Models\Company;
use App\Models\EmailSetting;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class OrderPdfService
{
    private function mailConfig(?EmailSetting $setting, ?Company $company): void
    {
        $password = null;
        if ($setting?->password_encrypted) {
            try {
                $password = Crypt::decryptString($setting->password_encrypted);
            } catch (\Throwable $e) {
                Log::warning('Falha ao descriptografar senha de e-mail.', ['error' => $e->getMessage()]);
            }
        }

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => $setting?->host,
            'mail.mailers.smtp.port' => (int) ($setting?->port ?? 0),
            'mail.mailers.smtp.username' => $setting?->username,
            'mail.mailers.smtp.password' => $password,
            'mail.mailers.smtp.encryption' => $setting?->encryption ?: null,
            'mail.from.address' => $setting?->from_address ?: ($company?->email ?: null),
            'mail.from.name' => $setting?->from_name ?: ($company?->name ?: 'OSYSTEM'),
        ]);
    }

    private function emailTemplateVariables(Order $order, ?Company $company): array
    {
        $safeNumber = str_pad((string) $order->number, 6, '0', STR_PAD_LEFT);

        return [
            '{{numero_os}}' => $safeNumber,
            '{{status_os}}' => ucfirst(str_replace('_', ' ', (string) $order->status)),
            '{{nome_empresa}}' => (string) ($company?->name ?? ''),
            '{{email_empresa}}' => (string) ($company?->email ?? ''),
            '{{telefone_empresa}}' => (string) ($company?->phone ?? ''),
            '{{nome_cliente}}' => (string) ($order->client?->name ?? ''),
            '{{email_cliente}}' => (string) ($order->client?->email ?? ''),
            '{{telefone_cliente}}' => (string) ($order->client?->phone ?? ''),
            '{{nome_tecnico}}' => (string) ($order->responsible?->name ?? ''),
            '{{data_abertura}}' => $order->opened_at ? $order->opened_at->format('d/m/Y H:i') : '',
            '{{data_fechamento}}' => $order->closed_at ? $order->closed_at->format('d/m/Y H:i') : '',
        ];
    }

    private function defaultEmailBodyHtml(Order $order, ?Company $company, string $context = 'closed'): string
    {
        if ($context === 'opened') {
            return <<<HTML
<div style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #1f2937; line-height: 1.6;">
    <p>Ola.</p>
    <p>A Ordem de Servico <strong>#{{numero_os}}</strong> foi aberta com sucesso.</p>
    <p><strong>Status:</strong> {{status_os}}<br><strong>Data de abertura:</strong> {{data_abertura}}</p>
    <p><strong>Cliente:</strong> {{nome_cliente}}<br><strong>Tecnico:</strong> {{nome_tecnico}}</p>
    <p>Atenciosamente,<br>{{nome_empresa}}</p>
</div>
HTML;
        }

        return <<<HTML
<div style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #1f2937; line-height: 1.6;">
    <p>Ola, {{nome_cliente}}.</p>
    <p>A Ordem de Servico <strong>#{{numero_os}}</strong> foi finalizada e o PDF segue em anexo.</p>
    <p><strong>Status:</strong> {{status_os}}<br><strong>Data de fechamento:</strong> {{data_fechamento}}</p>
    <p>Em caso de duvidas, entre em contato com {{nome_empresa}}.</p>
    <p>Atenciosamente,<br>{{nome_empresa}}</p>
</div>
HTML;
    }

    private function renderEmailBodyHtml(?string $template, Order $order, ?Company $company, string $context = 'closed'): string
    {
        $template = trim((string) $template) !== '' ? (string) $template : $this->defaultEmailBodyHtml($order, $company, $context);
        $vars = [];

        // Escape placeholder values so custom HTML remains editable without exposing raw dynamic content.
        foreach ($this->emailTemplateVariables($order, $company) as $key => $value) {
            $vars[$key] = e($value);
        }

        return strtr($template, $vars);
    }

    private function emailBodyTemplate(?EmailSetting $setting, string $context): ?string
    {
        if (! $setting) {
            return null;
        }

        if ($context === 'opened') {
            return $setting->body_html_opened ?: null;
        }

        return $setting->body_html_closed ?: ($setting->body_html ?: null);
    }

    private function sendHtmlEmails(array $recipients, string $subject, string $bodyHtml, ?string $filename = null, ?string $bytes = null): void
    {
        $sent = [];

        foreach ($recipients as $recipient) {
            $email = trim((string) $recipient);
            if ($email === '' || isset($sent[$email])) {
                continue;
            }

            $sent[$email] = true;

            try {
                Mail::html($bodyHtml, function ($message) use ($email, $subject, $bytes, $filename) {
                    $message->to($email)->subject($subject);

                    if ($filename !== null && $bytes !== null) {
                        $message->attachData($bytes, $filename, ['mime' => 'application/pdf']);
                    }
                });
            } catch (\Throwable $e) {
                Log::warning('Falha ao enviar e-mail da OS.', [
                    'email' => $email,
                    'subject' => $subject,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    private function pdfBytes(Order $order, ?Company $company, bool $hideValues): string
    {
        $order->loadMissing(['client', 'services', 'responsible']);

        $pdf = Pdf::loadView('pdf.order', [
            'order' => $order,
            'company' => $company,
            'hideValues' => $hideValues,
        ])->setPaper('a4')->setOptions([
            'defaultFont' => 'DejaVu Sans',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 96,
        ]);

        return $pdf->output();
    }

    private function pdfFilename(Order $order): string
    {
        $safeNumber = str_pad((string) $order->number, 6, '0', STR_PAD_LEFT);
        return "OS-{$safeNumber}.pdf";
    }

    public function generateAndStore(Order $order): Order
    {
        $order->loadMissing(['client', 'services', 'responsible']);
        $company = Company::query()->first();

        $safeNumber = str_pad((string) $order->number, 6, '0', STR_PAD_LEFT);
        $path = "orders/OS-{$safeNumber}.pdf";

        Storage::disk('local')->put($path, $this->pdfBytes($order, $company, false));

        $order->pdf_path = $path;
        $order->pdf_generated_at = now();
        $order->save();

        return $order;
    }

    public function sendClosedEmails(Order $order): void
    {
        $order->loadMissing(['client', 'services', 'responsible']);
        $company = Company::query()->first();

        $setting = EmailSetting::query()->first();
        if (! $setting || ! $setting->enabled) {
            return;
        }

        $this->mailConfig($setting, $company);

        $recipients = [
            ['email' => $company?->email, 'hideValues' => false],
            ['email' => $order->client?->email, 'hideValues' => true],
            ['email' => $order->responsible?->email, 'hideValues' => true],
        ];

        $filename = $this->pdfFilename($order);
        $safeNumber = str_pad((string) $order->number, 6, '0', STR_PAD_LEFT);
        $subject = "OS {$safeNumber} - Finalizada";
        $bodyHtml = $this->renderEmailBodyHtml($this->emailBodyTemplate($setting, 'closed'), $order, $company, 'closed');

        $cache = [];

        foreach ($recipients as $r) {
            $email = trim((string) ($r['email'] ?? ''));
            if ($email === '') {
                continue;
            }

            $hideValues = (bool) ($r['hideValues'] ?? true);
            $cacheKey = $hideValues ? 'hide' : 'full';

            try {
                if (! array_key_exists($cacheKey, $cache)) {
                    $cache[$cacheKey] = $this->pdfBytes($order, $company, $hideValues);
                }
                $bytes = $cache[$cacheKey];

                $this->sendHtmlEmails([$email], $subject, $bodyHtml, $filename, $bytes);
            } catch (\Throwable $e) {
                Log::warning('Falha ao enviar PDF da OS por e-mail.', [
                    'order_id' => $order->id,
                    'email' => $email,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    public function sendOpenedEmails(Order $order): void
    {
        $order->loadMissing(['client', 'services', 'responsible']);
        $company = Company::query()->first();

        $setting = EmailSetting::query()->first();
        if (! $setting || ! $setting->enabled) {
            return;
        }

        $this->mailConfig($setting, $company);

        $safeNumber = str_pad((string) $order->number, 6, '0', STR_PAD_LEFT);
        $subject = "OS {$safeNumber} - Aberta";
        $bodyHtml = $this->renderEmailBodyHtml($this->emailBodyTemplate($setting, 'opened'), $order, $company, 'opened');

        $this->sendHtmlEmails([
            $company?->email,
            $order->responsible?->email,
        ], $subject, $bodyHtml);
    }
}
