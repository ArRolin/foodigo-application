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
        Schema::table('delivery_men', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->string('country_code')->nullable();
            // phone column already exists, so we skip adding it
            $table->string('date_of_birth')->nullable();
            $table->string('city_id')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('address')->nullable();
            $table->string('document_type_id')->nullable();
            $table->string('document_number')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('document')->nullable();
            $table->string('short_note')->nullable();
            $table->string('vehicle_type_id')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('vehicle_image')->nullable();
            $table->string('otp')->nullable();
            $table->string('otp_expires_at')->nullable();
            $table->string('is_email_verified')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('delivery_men', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('country_code');
            // phone column was not added by this migration, so we don't drop it
            $table->dropColumn('date_of_birth');
            $table->dropColumn('city_id');
            $table->dropColumn('zip_code');
            $table->dropColumn('address');
            $table->dropColumn('document_type_id');
            $table->dropColumn('document_number');
            $table->dropColumn('profile_image');
            $table->dropColumn('document');
            $table->dropColumn('short_note');
            $table->dropColumn('vehicle_type_id');
            $table->dropColumn('vehicle_number');
            $table->dropColumn('vehicle_image');
            $table->dropColumn('otp');
            $table->dropColumn('otp_expires_at');
            $table->dropColumn('is_email_verified');
        });
    }
};

