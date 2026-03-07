<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('expediting_equipment_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('expediting_equipment_histories', 'ip_address')) {
                $table->string('ip_address')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('expediting_equipment_histories', function (Blueprint $table) {
            if (Schema::hasColumn('expediting_equipment_histories', 'ip_address')) {
                $table->dropColumn('ip_address');
            }
        });
    }
};
