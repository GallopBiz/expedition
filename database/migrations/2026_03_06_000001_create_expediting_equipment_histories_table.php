<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('expediting_equipment_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediting_equipment_id');
            $table->string('field_changed');
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->string('changed_by');
            $table->timestamp('changed_at')->nullable();
            $table->foreign('expediting_equipment_id')->references('id')->on('expediting_equipments')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expediting_equipment_histories');
    }
};
