<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(false);
            $table->string('mailer', 30)->default('smtp');

            $table->string('host', 150)->nullable();
            $table->unsignedInteger('port')->nullable();
            $table->string('username', 150)->nullable();
            $table->text('password_encrypted')->nullable();
            $table->string('encryption', 10)->nullable();

            $table->string('from_address', 150)->nullable();
            $table->string('from_name', 150)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_settings');
    }
};
