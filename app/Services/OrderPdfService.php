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
    private function pdfBytes(Order $order, ?Company $company, bool $hideValues): string
    {
        $order->loadMissing(['client', 'services', 'responsible']);

        $pdf = Pdf::loadView('pdf.order', [
            'order' => $order,
            'company' => $company,
            'hideValues' => $hideValues,
        ])->setPaper('a4');

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

        $password = null;
        if ($setting->password_encrypted) {
            try {
                $password = Crypt::decryptString($setting->password_encrypted);
            } catch (\Throwable $e) {
                Log::warning('Falha ao descriptografar senha de e-mail.', ['error' => $e->getMessage()]);
            }
        }

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => $setting->host,
            'mail.mailers.smtp.port' => (int) $setting->port,
            'mail.mailers.smtp.username' => $setting->username,
            'mail.mailers.smtp.password' => $password,
            'mail.mailers.smtp.encryption' => $setting->encryption ?: null,
            'mail.from.address' => $setting->from_address ?: ($company?->email ?: null),
            'mail.from.name' => $setting->from_name ?: ($company?->name ?: 'OSYSTEM'),
        ]);

        $recipients = [
            ['email' => $company?->email, 'hideValues' => false],
            ['email' => $order->client?->email, 'hideValues' => true],
            ['email' => $order->responsible?->email, 'hideValues' => true],
        ];

        $filename = $this->pdfFilename($order);
        $safeNumber = str_pad((string) $order->number, 6, '0', STR_PAD_LEFT);
        $subject = "OS {$safeNumber} - Finalizada";
        $body = "Segue em anexo o PDF da Ordem de Serviço OS {$safeNumber}.";

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

                Mail::raw($body, function ($message) use ($email, $subject, $bytes, $filename) {
                    $message->to($email)->subject($subject);
                    $message->attachData($bytes, $filename, ['mime' => 'application/pdf']);
                });
            } catch (\Throwable $e) {
                Log::warning('Falha ao enviar PDF da OS por e-mail.', [
                    'order_id' => $order->id,
                    'email' => $email,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
