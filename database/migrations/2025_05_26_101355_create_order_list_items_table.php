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
        Schema::create('order_list_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('user_panals');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('admin_products');

            $table->unsignedBigInteger('customer_info_id')->nullable();
            $table->foreign('customer_info_id')->references('id')->on('customer_infos');

            $table->unsignedBigInteger('order_list_id')->nullable();
            $table->foreign('order_list_id')->references('id')->on('order_lists');

            $table->string('order_number');

            $table->integer('item_quentity')->default(1);

            $table->string('order_create_time');

            $table->integer('item_price'); //admin price
            $table->integer('unit_price'); //user price

            $table->integer('product_code')->nullable();
            $table->string('packing_user')->nullable();
            $table->string('packing_time')->nullable();

            $table->string('order_status')->default('Pending');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_list_items');
    }
};
