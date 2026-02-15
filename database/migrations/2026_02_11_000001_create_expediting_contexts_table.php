<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expediting_contexts', function (Blueprint $table) {
            $table->id();
            $table->string('supplier');
            $table->string('workpackage_name');
            $table->string('po_number');
            $table->string('lli')->nullable();
            $table->string('expediting_category')->nullable();
            $table->date('order_date')->nullable();
            $table->string('contract_data_available_dmcs')->nullable();
            $table->string('incoterms')->nullable();
            $table->string('exyte_procurement_contract_manager')->nullable();
            $table->string('customer_procurement_contact')->nullable();
            $table->string('kickoff_status')->nullable();
            $table->string('technical_workpackage_owner')->nullable();
            $table->date('forecast_delivery_to_site')->nullable();
            $table->timestamps();
            $table->unique(['supplier', 'workpackage_name', 'po_number'], 'unique_context');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expediting_contexts');
    }
};
