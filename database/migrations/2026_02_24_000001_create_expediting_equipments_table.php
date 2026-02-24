<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('expediting_equipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediting_form_id');
            $table->string('name');
            $table->integer('design')->nullable();
            $table->integer('material')->nullable();
            $table->integer('fab')->nullable();
            $table->integer('fat')->nullable();
            $table->string('status')->nullable();
            $table->string('subsupplier')->nullable();
            $table->integer('qty')->nullable();
            $table->string('place')->nullable();
            $table->string('order_status')->nullable();
            $table->string('drawing')->nullable();
            $table->string('scope')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->integer('duration')->nullable();
            $table->date('fatdate')->nullable();
            $table->date('contractualdate')->nullable();
            $table->date('actualdate')->nullable();
            $table->string('openpoints')->nullable();
            $table->text('remarks')->nullable();
            $table->json('checks')->nullable();
            $table->timestamps();

            $table->foreign('expediting_form_id')->references('id')->on('expediting_forms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expediting_equipments');
    }
};
