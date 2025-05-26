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
        Schema::create('collect_product_stock_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('collection_number');
            $table->foreignId('collect_product_stock_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('admin_product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('buy_price');
            $table->unsignedBigInteger('collection_user')->nullable();
            $table->foreign('collection_user')->references('id')->on('users');
            $table->string('stock_status')->default('Instock');
            $table->string('Order_number')->nullable();
            $table->string('track_number')->nullable();

            $table->unsignedBigInteger('packing_user')->nullable();
            $table->foreign('packing_user')->references('id')->on('users');
            $table->string('packing_time')->nullable();

            $table->unsignedBigInteger('droaping_user')->nullable();
            $table->foreign('droaping_user')->references('id')->on('users');
            $table->string('droaping_time')->nullable();

            $table->unsignedBigInteger('return_user')->nullable();
            $table->foreign('return_user')->references('id')->on('users');
            $table->string('return_time')->nullable();
            $table->string('return_confirm_status')->nullable();
            $table->unsignedBigInteger('return_confirm_user')->nullable();
            $table->foreign('return_confirm_user')->references('id')->on('users');
            $table->string('return_confirm_time')->nullable();
            
            $table->string('sell_price')->nullable();
            $table->timestamps('Asia/Dhaka');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collect_prodcut_stock_lists');
    }
};
