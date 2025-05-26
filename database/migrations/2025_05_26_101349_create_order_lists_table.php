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
        Schema::create('order_lists', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('user_panals');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('admin_products');

            $table->unsignedBigInteger('customer_info_id')->nullable();
            $table->foreign('customer_info_id')->references('id')->on('customer_infos');

            $table->string('order_number');

            $table->string('order_create_time');

            $table->integer('item_price'); //admin price

            $table->string('verified_status')->default('check');

            $table->integer('item_quentity'); //2
            $table->integer('unit_price'); //300
            $table->integer('paid_price'); //300*2 =600

            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lists');
    }
};
