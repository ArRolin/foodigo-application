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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('restaurant_id');
            $table->string('size')->nullable();
            $table->decimal('size_price', 10, 2)->default(0);
            $table->integer('qty')->default(1);
            $table->json('addons')->nullable();
            $table->decimal('addon_price', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);
            $table->enum('status', ['active', 'inactive', 'ordered'])->default('active');
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['restaurant_id']);
            $table->index(['product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
}; 