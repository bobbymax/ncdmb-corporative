<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('account_code_id')->unsigned();
            $table->foreign('account_code_id')->references('id')->on('account_codes')->onDelete('cascade');
            $table->bigInteger('budget_head_id')->unsigned();
            $table->foreign('budget_head_id')->references('id')->on('budget_heads')->onDelete('cascade');
            $table->string('name');
            $table->date('entry_date')->nullable();
            $table->decimal('amount', $precision = 30, $scale = 2)->default(0);
            $table->text('description')->nullable();
            $table->enum('payment_type', ['credit', 'debit'])->default('debit');
            $table->enum('payment_methods', ['electronic', 'check', 'cash'])->default('electronic');
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
        Schema::dropIfExists('journals');
    }
}
