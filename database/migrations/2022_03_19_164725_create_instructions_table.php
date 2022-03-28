<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('loan_id')->unsigned();
            $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
            $table->decimal('capital', $precision = 30, $scale = 2)->default(0);
            $table->decimal('installment', $precision = 30, $scale = 2)->default(0);
            $table->decimal('interest', $precision = 30, $scale = 2)->default(0);
            $table->decimal('interestSum', $precision = 30, $scale = 2)->default(0);
            $table->decimal('remain', $precision = 30, $scale = 2)->default(0);
            $table->dateTime('due')->nullalble();
            $table->boolean('paid')->default(false);
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
        Schema::dropIfExists('instructions');
    }
}
