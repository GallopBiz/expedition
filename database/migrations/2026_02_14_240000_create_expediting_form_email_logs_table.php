<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('expediting_form_email_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expediting_form_id');
            $table->string('recipient_email');
            $table->string('sent_by')->nullable();
            $table->timestamp('sent_at')->useCurrent();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->foreign('expediting_form_id')->references('id')->on('expediting_forms')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expediting_form_email_logs');
    }
};