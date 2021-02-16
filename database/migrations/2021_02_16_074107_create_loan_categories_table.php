<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('budget_head_id')->unsigned();
            $table->foreign('budget_head_id')->references('id')->on('budget_heads')->onDelete('cascade');

            $table->string('name');
            $table->string('label')->unique();
            $table->text('description')->nullable();
            $table->integer('interest')->default(0);
            $table->integer('restriction')->default(0);
            $table->integer('committment')->default(0);
            $table->decimal('amount', $precision = 30, $scale = 2)->default(0);
            $table->decimal('balance', $precision = 30, $scale = 2)->default(0);
            $table->decimal('limit', $precision = 30, $scale = 2)->default(0);
            $table->enum('payable', ['undefined', 'contribution', 'salary', 'upfront'])->default('undefined');
            $table->enum('frequency', ['monthly', 'annually', 'special', 'rated'])->default('monthly');
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
        Schema::dropIfExists('loan_categories');
    }
}
