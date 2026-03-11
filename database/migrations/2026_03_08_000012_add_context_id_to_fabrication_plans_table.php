<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('fabrication_plans', function (Blueprint $table) {
            $table->unsignedBigInteger('context_id')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('fabrication_plans', function (Blueprint $table) {
            $table->dropColumn('context_id');
        });
    }
};
