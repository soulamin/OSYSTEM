<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->nullable();
            $table->string('cnpj', 20)->nullable()->index();
            $table->longText('logo_image')->nullable();

            $table->string('zip', 20)->nullable();
            $table->string('street', 150)->nullable();
            $table->string('number', 30)->nullable();
            $table->string('complement', 80)->nullable();
            $table->string('district', 80)->nullable();
            $table->string('city', 80)->nullable();
            $table->string('state', 2)->nullable();

            $table->string('phone', 30)->nullable();
            $table->string('email', 150)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

