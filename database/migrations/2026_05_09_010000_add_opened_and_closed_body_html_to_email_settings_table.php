<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('email_settings', function (Blueprint $table) {
            $table->longText('body_html_opened')->nullable()->after('body_html');
            $table->longText('body_html_closed')->nullable()->after('body_html_opened');
        });

        DB::table('email_settings')
            ->whereNull('body_html_closed')
            ->update([
                'body_html_closed' => DB::raw('body_html'),
            ]);
    }

    public function down(): void
    {
        Schema::table('email_settings', function (Blueprint $table) {
            $table->dropColumn(['body_html_opened', 'body_html_closed']);
        });
    }
};
