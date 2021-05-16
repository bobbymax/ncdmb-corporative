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
            $table->bigInteger('user_id')->unsigned(); // logged in user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('budget_head_id')->unsigned(); // editable dropdown
            $table->foreign('budget_head_id')->references('id')->on('budget_heads')->onDelete('cascade');
            $table->bigInteger('receive_id')->unsigned(); // editable dropdown receives
            $table->foreign('receive_id')->references('id')->on('receives')->onDelete('cascade');

            $table->string('reference')->unique(); // automatically generated
            $table->date('due_date')->nullable(); // editable
            $table->decimal('amount', $precision = 30, $scale = 2)->default(0); // editable
            $table->text('description')->nullable(); // editable textbox

            $table->enum('currency', ['NGN', 'USD', 'GBP'])->default('NGN'); // editable dropdown
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
