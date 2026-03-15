<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('material_plans', function (Blueprint $table) {
            $table->text('material_comment')->nullable()->after('last_date');
        });
    }
    public function down()
    {
        Schema::table('material_plans', function (Blueprint $table) {
            $table->dropColumn('material_comment');
        });
    }
};
