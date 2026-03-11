<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('calendar_updates', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // inspection, material, fabrication
            $table->date('date')->nullable();
            $table->string('for')->nullable(); // inspection for
            $table->string('location')->nullable();
            $table->string('contract_date')->nullable();
            $table->string('first_handover_date')->nullable();
            $table->string('last_date')->nullable();
            $table->string('last_update')->nullable();
            $table->string('files')->nullable(); // comma-separated file paths
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('calendar_updates');
    }
};
