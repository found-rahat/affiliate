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
        Schema::create('add_carts', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->integer('product_id');
            $table->integer('sell_price');
            $table->integer('quentity');
            $table->boolean('status')->default(true);
            $table->timestamps('Asia/Dhaka');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_carts');
    }
};
