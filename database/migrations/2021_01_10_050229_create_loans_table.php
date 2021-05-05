<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('budget_head_id')->unsigned(); // Editable (select)
            $table->string('code')->unique();
            $table->decimal('amount', $precision = 30, $scale = 2)->default(0); // Editable
            $table->string('reason')->default('undefined'); // Editable (select)
            $table->longText('description')->nullable(); // Editable
            $table->enum('status', ['pending', 'registered', 'approved', 'denied', 'disbursed', 'closed'])->default('pending');
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
        Schema::dropIfExists('loans');
    }
}
