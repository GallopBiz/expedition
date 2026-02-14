<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('expediting_form_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediting_form_id');
            $table->string('field_changed');
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->string('changed_by'); // user email or id
            $table->timestamp('changed_at')->useCurrent();
            $table->foreign('expediting_form_id')->references('id')->on('expediting_forms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expediting_form_histories');
    }
};
