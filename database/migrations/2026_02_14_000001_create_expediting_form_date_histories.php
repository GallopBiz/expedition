<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expediting_form_date_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediting_form_id');
            $table->string('field'); // e.g. start_of_manufacturing_actual
            $table->date('old_value')->nullable();
            $table->date('new_value')->nullable();
            $table->unsignedBigInteger('changed_by'); // user id
            $table->timestamp('changed_at');
            $table->foreign('expediting_form_id')->references('id')->on('expediting_forms')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expediting_form_date_histories');
    }
};
