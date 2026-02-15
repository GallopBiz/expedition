<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expediting_form_forecast_delivery_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediting_form_id');
            $table->date('old_value')->nullable();
            $table->date('new_value')->nullable();
            $table->string('changed_by')->nullable();
            $table->timestamp('changed_at')->nullable();
            $table->foreign('expediting_form_id', 'ef_forecast_hist_form_id_fk')->references('id')->on('expediting_forms')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expediting_form_forecast_delivery_histories');
    }
};
