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
        Schema::create('customer_infos', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('user_panals');
            
            $table->string('order_number');

            $table->string('name');
            $table->string('address');
            $table->string('phone');

            $table->integer('item_quentity'); //total quentity
            $table->integer('total_paid'); //total price

            $table->string('order_create_time');

            $table->integer('discount')->nullable(); //if
            $table->string('discount_user')->nullable();

            $table->string('payment_method')->default('COD');
            $table->string('payment_status')->default('unpaid');

            $table->string('confirm_time')->nullable();
            $table->string('confirm_user')->nullable();

            $table->integer('shipping_fee'); // 60
            $table->string('shipping_provider'); //pathao

            $table->string('shipping_provider_delivery_code')->nullable();
            
            $table->string('shipped_type')->nullable(); //if outbound then pending confirm then change confirm
            $table->string('shipped_time')->nullable();
            $table->string('shipped_user')->nullable();
            $table->integer('shippment_id')->nullable();

            $table->integer('pre_payment')->nullable(); //if
            $table->string('pre_payment_user')->nullable();

            $table->string('order_note')->nullable();

            $table->string('hold_reason')->nullable();
            $table->string('hold_time')->nullable();

            $table->string('cancel_reason')->nullable();
            $table->string('cancel_time')->nullable();

            $table->string('delivery_time')->nullable();

            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_infos');
    }
};
