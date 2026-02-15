<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expediting_forms', function (Blueprint $table) {
            $table->date('forecast_delivery_to_site')->nullable()->after('actual_delivery_to_site_supplier');
        });
    }

    public function down(): void
    {
        Schema::table('expediting_forms', function (Blueprint $table) {
            $table->dropColumn('forecast_delivery_to_site');
        });
    }
};
