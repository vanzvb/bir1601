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
        Schema::create('payroll_cutoff_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('pSummaryID', 50);
            $table->string('dtrSummaryID', 200);
            $table->string('payslipNo', 50);
            $table->string('empID', 250);
            $table->integer('month');   // int 11
            $table->integer('cutoff');   // int 1
            $table->integer('year');   // int 11
            $table->date('paydate');   
            $table->string('period', 100)->nullable();
            $table->string('basicpay', 500);
            $table->string('semim', 500);
            $table->string('dailyrate', 500);
            $table->string('hourlyrate', 500);
            $table->string('paidvl', 500);
            $table->string('paidsl', 500);
            $table->string('paidbl', 500);
            $table->string('allowance', 500);
            $table->string('total_dmm', 500);
            $table->string('total_premium', 500);
            $table->string('total_ot', 500);
            $table->string('total_nd', 500);
            $table->string('total_ndot', 500);
            $table->string('shutdown', 500);
            $table->string('tardy', 500);
            $table->string('absent', 500);
            $table->string('ut', 500);
            $table->string('neg_snwh', 500);
            $table->string('sss', 500);
            $table->string('philhealth', 500);
            $table->string('pagibig', 500);
            $table->string('vl', 500);
            $table->string('sl', 500);
            $table->string('bl', 500);
            $table->string('total_e', 500);
            $table->string('total_d', 500);
            $table->string('net_p', 500);
            $table->string('taxbaseID', 50);
            $table->string('tax', 500);
            $table->string('adjustment_add', 500);
            $table->string('adjustment_reason', 50)->nullable();
            $table->string('adjustment_minus', 50)->nullable();
            $table->integer('emailsent'); // int 1
            $table->integer('hasPDF'); // int 1
            $table->integer('ph_rowID'); // int 11
            $table->integer('pi_rowID'); // int 11
            $table->string('net_proceeds', 500);
            $table->string('sss_rowID', 500);
            $table->decimal('workingDays', 11, 2);
            $table->decimal('offset_hrs', 11, 2)->nullable();
            $table->integer('isEdited'); // int 0
            $table->integer('hasStat'); // int 1
            $table->integer('hasDmm'); // int 1
            $table->integer('hasAllowance'); // int 1
            $table->integer('isProRated'); // int 0
            $table->integer('isOverride')->nullable(); // int 1
            $table->dateTime('lastSentAt')->nullable();
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_cutoff_summaries');
    }
};
