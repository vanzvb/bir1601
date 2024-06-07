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
        Schema::create('company_bous', function (Blueprint $table) {
            $table->id();
            $table->string('bouID', 50)->nullable();
            $table->string('bouName', 50)->nullable();
            $table->string('companyID', 50)->nullable();
            $table->integer('isDefault')->default(0);
            $table->string('manager', 50);
            $table->string('manager_email', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_bous');
    }
};
