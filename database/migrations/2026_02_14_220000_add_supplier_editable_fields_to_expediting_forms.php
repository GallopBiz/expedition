<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('expediting_forms', function (Blueprint $table) {
            $table->string('equipment_type_tag_number')->nullable();
            $table->text('detailed_scope_of_delivery')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('sub_supplier')->nullable();
            $table->string('place_of_manufacturing')->nullable();
            $table->string('order_status')->nullable();
            $table->string('drawing_approval')->nullable();
            $table->integer('design_status')->nullable();
            $table->integer('material_status')->nullable();
            $table->integer('fabrication_status')->nullable();
            $table->integer('fat_status')->nullable();
            $table->date('start_of_manufacturing_actual')->nullable();
            $table->date('end_of_manufacturing')->nullable();
            $table->date('fat_date_actual')->nullable();
            $table->date('contractual_delivery_to_site_date')->nullable();
            $table->date('actual_delivery_to_site_supplier')->nullable();
            $table->integer('manufacturing_duration')->nullable();
            $table->string('ready_for_shipment')->nullable();
            $table->string('storage_at_supplier')->nullable();
            $table->string('delivered')->nullable();
            $table->text('comments')->nullable();
        });
    }

    public function down()
    {
        Schema::table('expediting_forms', function (Blueprint $table) {
            $table->dropColumn([
                'equipment_type_tag_number',
                'detailed_scope_of_delivery',
                'quantity',
                'sub_supplier',
                'place_of_manufacturing',
                'order_status',
                'drawing_approval',
                'design_status',
                'material_status',
                'fabrication_status',
                'fat_status',
                'start_of_manufacturing_actual',
                'end_of_manufacturing',
                'fat_date_actual',
                'contractual_delivery_to_site_date',
                'actual_delivery_to_site_supplier',
                'manufacturing_duration',
                'ready_for_shipment',
                'storage_at_supplier',
                'delivered',
                'comments',
            ]);
        });
    }
};
