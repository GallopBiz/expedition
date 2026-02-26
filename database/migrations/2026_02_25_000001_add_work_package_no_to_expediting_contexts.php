<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expediting_contexts', function (Blueprint $table) {
            $table->string('work_package_no')->nullable()->after('workpackage_name');
        });
    }

    public function down(): void
    {
        Schema::table('expediting_contexts', function (Blueprint $table) {
            $table->dropColumn('work_package_no');
        });
    }
};
