<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('expediting_form_actual_delivery_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediting_form_id');
            $table->date('old_value')->nullable();
            $table->date('new_value')->nullable();
            $table->string('changed_by');
            $table->timestamp('changed_at')->useCurrent();
            $table->foreign('expediting_form_id', 'efad_hist_form_id_fk')
                ->references('id')->on('expediting_forms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expediting_form_actual_delivery_histories');
    }
};
