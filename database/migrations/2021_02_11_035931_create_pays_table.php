<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('beneficiary_id')->unsigned();
            $table->foreign('beneficiary_id')->references('id')->on('beneficiaries')->onDelete('cascade');
            $table->string('trxRef')->unique();
            $table->bigInteger('payable_id')->unsigned();
            $table->string('payable_type');
            $table->string('title');
            $table->string('label')->unique();
            $table->decimal('amount', $precision = 30, $scale = 2)->default(0);
            $table->enum('type', ['member', 'staff', 'third-party'])->default('member');
            $table->enum('status', ['pending', 'refunded', 'unpaid', 'paid'])->default('pending');
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
        Schema::dropIfExists('pays');
    }
}
