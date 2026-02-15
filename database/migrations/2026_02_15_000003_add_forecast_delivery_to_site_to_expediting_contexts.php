<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expediting_contexts', function (Blueprint $table) {
            $table->date('forecast_delivery_to_site')->nullable()->after('technical_workpackage_owner');
        });
    }

    public function down(): void
    {
        Schema::table('expediting_contexts', function (Blueprint $table) {
            $table->dropColumn('forecast_delivery_to_site');
        });
    }
};
