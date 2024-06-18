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
        Schema::create('pre_bir_1601s', function (Blueprint $table) {
            $table->id();
            $table->string('empID'); // Employee ID
            // $table->integer('cutoff')->nullable(); //cutoff 0 = 1-15 / 1 = 16-30
            $table->string('tin')->nullable();
            $table->unsignedBigInteger('bouID')->nullable();
            $table->integer('month')->nullable();   // int 11
            $table->integer('year')->nullable();   // int 11
            $table->string('basic_pay_first')->nullable(); // cutoff 1-15
            $table->string('basic_pay_second')->nullable(); // cutoff 16-31
            $table->string('basic_pay_total')->nullable(); // basic
            $table->string('premium_first')->nullable(); // cutoff 1-15
            $table->string('premium_second')->nullable(); // cutoff 16-31
            $table->string('tot_premium')->nullable();  // premium
            $table->string('dmm_first')->nullable(); // cutoff 1-15
            $table->string('dmm_second')->nullable(); // cutoff 16-31
            $table->string('tot_dmm')->nullable(); //diminimis
            $table->string('proj_exp_first')->nullable(); // cutoff 1-15
            $table->string('proj_exp_second')->nullable(); // cutoff 16-31
            $table->string('tot_proj_exp')->nullable(); // (proj exp reim) total_e in payroll_cutoff_summary
            $table->string('deduction_first')->nullable(); // cutoff 1-15
            $table->string('deduction_second')->nullable(); // cutoff 16-31
            $table->string('tot_deduction')->nullable(); // (deduction) total_d in payroll_cutoff_summary
            $table->string('gross_pay_first')->nullable(); // cutoff 1-15
            $table->string('gross_pay_second')->nullable(); // cutoff 16-31
            $table->string('tot_gross_pay_salary')->nullable(); // gross pay
            $table->string('tax_first')->nullable(); // cutoff 1-15
            $table->string('tax_second')->nullable(); // cutoff 16-31
            $table->string('tot_tax')->nullable(); // taxable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_bir_1601s');
    }
};
