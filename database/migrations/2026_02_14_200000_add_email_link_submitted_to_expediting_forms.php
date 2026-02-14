<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('expediting_forms', function (Blueprint $table) {
            $table->boolean('email_link_submitted')->default(false);
        });
    }

    public function down()
    {
        Schema::table('expediting_forms', function (Blueprint $table) {
            $table->dropColumn('email_link_submitted');
        });
    }
};
