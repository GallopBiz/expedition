<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gst_number');
            $table->string('contact1_name')->nullable()->after('company_address');
            $table->string('contact1_position')->nullable()->after('contact1_name');
            $table->string('contact1_mail')->nullable()->after('contact1_position');
            $table->string('contact1_mobile')->nullable()->after('contact1_mail');
            $table->string('contact1_phone')->nullable()->after('contact1_mobile');
            $table->string('contact2_name')->nullable()->after('contact1_phone');
            $table->string('contact2_position')->nullable()->after('contact2_name');
            $table->string('contact2_mail')->nullable()->after('contact2_position');
            $table->string('contact2_mobile')->nullable()->after('contact2_mail');
            $table->string('contact2_phone')->nullable()->after('contact2_mobile');
        });
    }
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gst_number')->nullable();
            $table->dropColumn([
                'contact1_name','contact1_position','contact1_mail','contact1_mobile','contact1_phone',
                'contact2_name','contact2_position','contact2_mail','contact2_mobile','contact2_phone',
            ]);
        });
    }
};
