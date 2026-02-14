<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expediting_forms', function (Blueprint $table) {
            $table->id();
            $table->string('work_package');
            $table->boolean('lli')->nullable();
            $table->string('expediting_category');
            $table->string('workpackage_name');
            $table->string('supplier');
            $table->date('order_date')->nullable();
            $table->boolean('contract_data_available_dmcs')->nullable();
            $table->string('po_number')->nullable();
            $table->string('incoterms')->nullable();
            $table->string('exyte_procurement_contract_manager')->nullable();
            $table->string('customer_procurement_contact')->nullable();
            $table->string('kickoff_status')->nullable();
            $table->string('technical_workpackage_owner')->nullable();
            $table->string('workstream_building')->nullable();
            $table->string('expediting_contact')->nullable();
            $table->string('created_by')->nullable();
            $table->boolean('email_link_submitted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expediting_forms');
    }
};
