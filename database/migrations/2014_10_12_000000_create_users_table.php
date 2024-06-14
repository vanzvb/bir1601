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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // new files from prod
            $table->string('lastName', 255)->nullable();
            $table->string('firstName', 255)->nullable();
            $table->string('middleName', 255)->nullable();
            $table->integer('typeName')->nullable();
            $table->string('roleName', 100)->nullable();
            $table->string('company', 255)->nullable();
            $table->string('jobTitle', 150)->nullable();
            $table->string('emailAdd', 255)->nullable();
            $table->date('birthDate')->nullable();
            $table->string('street', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('zipCode', 100)->nullable();
            $table->string('language', 100)->nullable();
            $table->string('timeZone', 100)->nullable();
            $table->string('hobbies', 100)->nullable();
            $table->string('landline', 15)->nullable();
            $table->string('mobile', 100)->nullable();
            $table->string('fax', 100)->nullable();
            $table->string('individ', 100)->nullable();
            $table->integer('status')->nullable();
            $table->string('biometricID', 100)->nullable();
            $table->integer('accountType')->nullable();
            $table->string('companyAccountCode', 50)->nullable();
            $table->integer('isSenior')->nullable();
            $table->integer('isPWD')->nullable();
            $table->text('lastmemo')->nullable();
            $table->date('bstdate')->nullable();
            $table->string('departmentID', 100)->nullable();
            $table->string('retailerName', 100)->nullable();
            $table->string('department', 100)->nullable();
            $table->string('emailAddref', 250)->nullable();
            $table->string('bouID', 50)->nullable();
            $table->string('tin', 50)->nullable();
            //

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
