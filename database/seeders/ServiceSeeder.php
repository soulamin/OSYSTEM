<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::query()->firstOrCreate(
            ['name' => 'Diagnóstico'],
            ['description' => 'Avaliação inicial do equipamento/serviço', 'value' => 50],
        );

        Service::query()->firstOrCreate(
            ['name' => 'Mão de obra'],
            ['description' => 'Serviço técnico', 'value' => 120],
        );
    }
}

