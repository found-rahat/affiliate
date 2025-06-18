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
        Schema::table('customer_infos', function (Blueprint $table) {
            $table->dateTime('delivery_failed_time')->nullable();
            $table->dateTime('return_time')->nullable();
            $table->string('return_confirm_user')->nullable();

            $table->decimal('buy_price', 10, 2)->nullable(); // or integer if you're using whole numbers
            $table->boolean('aff_user_paid')->default(false); // change type if needed
            $table->boolean('cod_paid')->default(false);
            $table->string('cod_paid_user')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_infos', function (Blueprint $table) {
           $table->dropColumn([
                'delivery_failed_time',
                'return_time',
                'return_confirm_user',
                'buy_price',
                'aff_user_paid',
                'cod_paid',
                'cod_paid_user',
            ]);
        });
    }
};
