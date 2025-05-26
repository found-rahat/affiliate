<?php

use Doctrine\DBAL\Schema\Table;
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
        Schema::create('collect_product_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('collection_number');
            $table->foreignId('admin_product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('quantity')->nullable()->default(0);
            $table->integer('paid_price')->nullable()->default(0);
            $table->unsignedBigInteger('collection_user')->nullable();
            $table->foreign('collection_user')->references('id')->on('users');
            $table->string('stock')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collect_product_stocks');
    }
};
