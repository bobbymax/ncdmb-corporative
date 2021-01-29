<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApproveablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approveables', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('approveable_id')->unsigned();
            $table->string('approveable_type');

            $table->text('remark')->nullable();
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
        Schema::dropIfExists('approveables');
    }
}
