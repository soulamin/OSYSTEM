<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClientSeeder::class,
            ServiceSeeder::class,
            OrderSeeder::class,
        ]);

        User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Administrador', 'password' => 'password', 'role' => 'admin'],
        );

        User::query()->firstOrCreate(
            ['email' => 'tecnico@example.com'],
            ['name' => 'Técnico', 'password' => 'password', 'role' => 'tecnico'],
        );

        $client = Client::query()->orderBy('id')->first();
        if ($client) {
            User::query()->firstOrCreate(
                ['email' => 'cliente@example.com'],
                ['name' => 'Cliente', 'password' => 'password', 'role' => 'cliente', 'client_id' => $client->id],
            );
        }
    }
}
