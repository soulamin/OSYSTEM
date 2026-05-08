<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class OrderPdfService
{
    public function generateAndStore(Order $order): Order
    {
        $order->loadMissing(['client', 'services', 'responsible']);
        $company = Company::query()->first();

        $pdf = Pdf::loadView('pdf.order', [
            'order' => $order,
            'company' => $company,
            'hideValues' => false,
        ])->setPaper('a4');

        $safeNumber = str_pad((string) $order->number, 6, '0', STR_PAD_LEFT);
        $path = "orders/OS-{$safeNumber}.pdf";

        Storage::disk('local')->put($path, $pdf->output());

        $order->pdf_path = $path;
        $order->pdf_generated_at = now();
        $order->save();

        return $order;
    }
}
