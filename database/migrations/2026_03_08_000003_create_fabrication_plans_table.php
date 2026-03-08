<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('fabrication_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('context_id');
            $table->date('fabrication_contract_date');
            $table->date('fabrication_first_handover_date')->nullable();
            $table->date('fabrication_last_update')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fabrication_plans');
    }
};
