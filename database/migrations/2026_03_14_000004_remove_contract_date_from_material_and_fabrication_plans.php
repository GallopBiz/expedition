<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('material_plans', function (Blueprint $table) {
            $table->dropColumn('contract_date');
        });
        Schema::table('fabrication_plans', function (Blueprint $table) {
            $table->dropColumn('fabrication_contract_date');
        });
    }
    public function down()
    {
        Schema::table('material_plans', function (Blueprint $table) {
            $table->date('contract_date')->nullable();
        });
        Schema::table('fabrication_plans', function (Blueprint $table) {
            $table->date('fabrication_contract_date')->nullable();
        });
    }
};
