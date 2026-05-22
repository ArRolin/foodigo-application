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
        if (!Schema::hasTable('reviews')) return;
        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'restaurant_id')) {
                $table->unsignedBigInteger('restaurant_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('restaurant_id');
        });
    }
};
