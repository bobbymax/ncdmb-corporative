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
            $table->bigInteger('transactionable_id')->unsigned();
            $table->string('transactionable_type');
            $table->string('code')->unique();
            $table->string('type')->nullable();
            $table->decimal('amount', $precision = 30, $scale = 2)->default(0);
            $table->enum('status', ['pending', 'disbursed', 'paid', 'unpaid'])->default('pending');
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
