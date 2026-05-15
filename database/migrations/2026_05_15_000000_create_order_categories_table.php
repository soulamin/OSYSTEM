<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->unique();
            $table->string('description', 255)->nullable();
            $table->timestamps();

            $table->index('name');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->nullable()
                ->after('client_id')
                ->constrained('order_categories')
                ->nullOnDelete();

            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropConstrainedForeignId('category_id');
        });

        Schema::dropIfExists('order_categories');
    }
};

