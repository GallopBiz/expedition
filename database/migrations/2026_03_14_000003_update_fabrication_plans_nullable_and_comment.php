<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('fabrication_plans', function (Blueprint $table) {
            $table->date('fabrication_contract_date')->nullable()->change();
            $table->text('fabrication_comment')->nullable()->after('fabrication_last_update');
        });
    }
    public function down()
    {
        Schema::table('fabrication_plans', function (Blueprint $table) {
            $table->dropColumn('fabrication_comment');
            $table->date('fabrication_contract_date')->nullable(false)->change();
        });
    }
};
