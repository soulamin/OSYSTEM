<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::query()->firstOrCreate(
            ['document' => '12345678901'],
            [
                'name' => 'Cliente Exemplo',
                'phone' => '11999999999',
                'email' => 'cliente@example.com',
                'zip' => '01001000',
                'street' => 'Praça da Sé',
                'number' => '100',
                'complement' => null,
                'district' => 'Sé',
                'city' => 'São Paulo',
                'state' => 'SP',
            ],
        );
    }
}

