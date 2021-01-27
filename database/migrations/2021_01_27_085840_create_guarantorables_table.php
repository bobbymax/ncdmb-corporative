<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuarantorablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guarantorables', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('guarantorable_id')->unsigned();
            $table->string('guarantorable_type');
            $table->text('remarks')->nullable();
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guarantorables');
    }
}
