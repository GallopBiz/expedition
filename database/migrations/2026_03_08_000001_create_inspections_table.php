<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('context_id');
            $table->date('inspection_date');
            $table->string('inspection_for');
            $table->string('inspection_location');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->json('files')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inspections');
    }
};
