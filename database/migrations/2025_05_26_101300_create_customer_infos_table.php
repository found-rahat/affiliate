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
            $table->string('user_name');
            
            $table->string('order_number');

            $table->string('name');
            $table->string('address');
            $table->string('phone');

            $table->string('item_quentity');
            $table->string('total_paid');

            $table->string('order_create_time')->default(now());

            $table->string('discount');
            $table->string('discount_user');

            $table->string('payment_method')->default('COD');
            $table->string('payment_status')->default('unpaid');

            $table->string('confirm_time');
            $table->string('confirm_user');

            $table->string('shipping_fee');
            $table->string('shipping_provider');
            $table->string('shipping_provider_delivery_code');
            $table->string('shipped_type');
            $table->string('shipped_time');
            $table->string('shipped_user');
            $table->string('shippment_id');

            $table->string('pre_payment');
            $table->string('pre_payment_user');

            $table->string('order_note');

            $table->string('hold_reason');
            $table->string('hold_time');

            $table->string('cancel_reason');
            $table->string('cancel_time');

            $table->string('delivery_time');

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
