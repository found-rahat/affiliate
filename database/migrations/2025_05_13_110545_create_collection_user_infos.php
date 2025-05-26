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
        Schema::create('collection_user_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('collection_number');
            $table->integer('quantity')->nullable()->default(0);

            $table->unsignedBigInteger('collection_user')->nullable();
            $table->foreign('collection_user')->references('id')->on('users');

            $table->integer('total_value')->default(0);
            $table->timestamps('Asia/Dhaka');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_user_infos');
    }
};
