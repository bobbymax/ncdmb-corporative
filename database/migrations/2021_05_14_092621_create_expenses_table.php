<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('budget_head_id')->unsigned();
            $table->foreign('budget_head_id')->references('id')->on('budget_heads')->onDelete('cascade');
            $table->bigInteger('receive_id')->unsigned();
            $table->foreign('receive_id')->references('id')->on('receives')->onDelete('cascade');

            $table->string('reference')->unique();
            $table->date('due_date')->nullable();
            $table->decimal('amount', $precision = 30, $scale = 2)->default(0);
            $table->text('description')->nullable();

            $table->enum('currency', ['NGN', 'USD', 'GBP'])->default('NGN');
            $table->enum('status', ['pending', 'batched', 'paid'])->default('pending');
            $table->boolean('completed')->default(false);
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
        Schema::dropIfExists('expenses');
    }
}
