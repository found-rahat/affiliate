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
        Schema::create('reportuses', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('type');
            $table->string('subject');
            $table->text('description')->nullable();
            $table->string('attachment')->nullable();
            $table->string('status',['Pending','InReview','Resolved','Rejected'])->default('Pending');
            $table->string('admin_user')->nullable();
            $table->text('admin_note')->nullable();
            $table->string('solve_date')->nullable();
            $table->timestamps('Asia/Dhaka');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportuses');
    }
};
