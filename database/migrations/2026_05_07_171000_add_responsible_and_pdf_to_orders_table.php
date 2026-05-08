<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('responsible_user_id')->nullable()->after('client_id')->constrained('users');
            $table->string('pdf_path')->nullable()->after('signature_signed_at');
            $table->timestamp('pdf_generated_at')->nullable()->after('pdf_path');
            $table->index('responsible_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['responsible_user_id']);
            $table->dropConstrainedForeignId('responsible_user_id');
            $table->dropColumn(['pdf_path', 'pdf_generated_at']);
        });
    }
};

