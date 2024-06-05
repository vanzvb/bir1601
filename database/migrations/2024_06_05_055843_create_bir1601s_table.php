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
        Schema::create('bir1601s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empID'); // Employee ID
            $table->integer('cutoff')->nullable(); //cutoff 0 = 1-15 / 1 = 16-30
            $table->decimal('basic_pay', 10, 2)->nullable(); //basic pay
            $table->decimal('total_premium', 10, 2)->nullable(); //premium
            $table->decimal('total_dmm', 10, 2)->nullable(); //diminimis
            $table->decimal('total_e', 10, 2)->nullable(); // proj exp reim
            $table->decimal('total_d', 10, 2)->nullable(); // deduction
            $table->decimal('total_gross_pay_salary', 10, 2)->nullable(); // gross pay
            $table->decimal('tax', 10, 2)->nullable(); // taxable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bir1601s');
    }
};
