<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('expediting_forms', function (Blueprint $table) {
            // $table->unsignedBigInteger('context_id')->nullable()->after('id'); // Already exists
            // $table->string('work_package'); // Already exists
            // $table->string('workstream_building'); // Already exists
            // $table->string('expediting_contact'); // Already exists
            // $table->foreign('context_id')->references('id')->on('expediting_contexts')->onDelete('cascade'); // Temporarily disabled to allow migration
            $table->unique(['context_id', 'work_package', 'workstream_building'], 'unique_execution');
        });
    }

    public function down(): void
    {
        Schema::table('expediting_forms', function (Blueprint $table) {
            $table->dropForeign(['context_id']);
            $table->dropUnique('unique_execution');
            $table->dropColumn(['context_id', 'work_package', 'workstream_building', 'expediting_contact']);
        });
    }
};
