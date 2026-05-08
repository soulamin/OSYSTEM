<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $client = Client::query()->where('document', '12345678901')->first();
        if (! $client) {
            return;
        }

        if (Order::query()->where('number', 1)->exists()) {
            return;
        }

        $services = Service::query()->limit(2)->get();
        if ($services->isEmpty()) {
            return;
        }

        DB::transaction(function () use ($client, $services) {
            $order = Order::create([
                'number' => 1,
                'client_id' => $client->id,
                'status' => Order::STATUS_ABERTA,
                'opened_at' => now(),
                'closed_at' => null,
                'notes' => 'OS criada via seeder',
                'total_value' => 0,
            ]);

            $total = 0.0;
            $sync = [];

            foreach ($services as $service) {
                $unit = (float) $service->value;
                $qty = 1;
                $total += round($unit * $qty, 2);

                $sync[$service->id] = [
                    'quantity' => $qty,
                    'unit_value' => $unit,
                ];
            }

            $order->services()->sync($sync);
            $order->update(['total_value' => round($total, 2)]);
        });
    }
}

