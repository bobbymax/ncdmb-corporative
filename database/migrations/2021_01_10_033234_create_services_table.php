<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('serviceCode')->unique();
            $table->string('category')->default('undefined'); // Editable (select)

            $table->longText('description')->nullable(); // Editable
            $table->date('request_date')->nullable(); // Editable
            $table->string('payment_method')->default('na'); // Editable (select)
            $table->enum('status', ['registered', 'approved', 'denied', 'completed'])->default('registered');
            $table->boolean('closed')->default(false);
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
        Schema::dropIfExists('services');
    }
}
