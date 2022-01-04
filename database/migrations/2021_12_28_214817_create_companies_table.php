<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('registration_no')->unique()->nullable();
            $table->string('tin_no')->unique()->nullable();

            $table->string('name');
            $table->string('label')->unique();
            $table->string('reference_no')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->enum('status', ['registered', 'verified', 'denied'])->default('registered');
            $table->enum('category', ['nigeria-owned', 'nigeria-company-owned-by-foreign-company', 'foreign-owned', 'government-owned'])->default('nigeria-owned');
            $table->enum('type', ['vendor', 'owner'])->default('vendor');
            $table->boolean('blacklisted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
