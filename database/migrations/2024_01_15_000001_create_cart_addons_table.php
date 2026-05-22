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
        Schema::create('cart_addons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('addon_id');
            $table->string('addon_name');
            $table->decimal('addon_price', 10, 2)->default(0);
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->index(['cart_id']);
            $table->index(['addon_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_addons');
    }
}; 