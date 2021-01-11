<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('code')->unique();
            $table->string('identifier')->nullable();
            $table->string('category')->nullable();
            $table->bigInteger('amount')->default(0);
            $table->enum('type', ['undefined', 'debit', 'credit'])->default('undefined');
            $table->enum('status', ['pending', 'disbursed', 'paid', 'unpaid'])->default('pending');
            $table->bigInteger('transactionable_id')->unsigned();
            $table->string('transactionable_type');
            $table->boolean('completed')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
