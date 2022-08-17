<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_fields', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('loan_id')->default(0);
            $table->bigInteger('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->string('takeOff')->default('undefined');
            $table->string('destination')->default('undefined');
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->string('airline')->nullable();
            $table->enum('type', ['local', 'international', 'other'])->default('other');
            $table->enum('trip', ['one-way', 'return', 'other'])->default('other');
            $table->enum('liquidate', ['partially', 'full', 'other'])->default('other');
            $table->enum('timeOfDay', ['morning', 'afternoon', 'evening', 'other'])->default('other');
            $table->decimal('amount', $precision=30, $scale=2)->default(0);
            $table->string('month')->nullable();
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
        Schema::dropIfExists('service_fields');
    }
}
