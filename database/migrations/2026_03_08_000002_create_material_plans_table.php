<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('material_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('context_id');
            $table->date('contract_date');
            $table->date('first_handover_date')->nullable();
            $table->date('last_date')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_plans');
    }
};
