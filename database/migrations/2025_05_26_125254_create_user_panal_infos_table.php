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
        Schema::create('user_panal_infos', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('user_panals');

            $table->string('user_refer_by')->nullable();
            $table->integer('total_user_balance')->default(0);
            $table->integer('total_user_paid')->default(0);
            $table->integer('total_user_Pre_Payment')->default(0);
            $table->integer('total_user_diposit')->default(0);
            $table->integer('total_user_Withdrew')->default(0);
            $table->integer('total_user_upload')->default(0);
            $table->integer('total_user_order')->default(0);

            $table->string('user_phone_numebr')->nullable();
            $table->string('profile_images')->nullable();
            $table->string('user_facebook_URL')->nullable();
            $table->string('user_ecommerce_url')->nullable();
            $table->string('user_last_login')->nullable();
            $table->string('user_last_ip_adress')->nullable();
            $table->string('user_payment_status')->default('unverified');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_panal_infos');
    }
};
