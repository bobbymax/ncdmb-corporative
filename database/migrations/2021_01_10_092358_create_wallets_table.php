<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('identifier')->unique()->nullable();
            $table->decimal('deposit', $precision = 30, $scale = 2)->default(0);
            $table->decimal('current', $precision = 30, $scale = 2)->default(0);
            $table->decimal('available', $precision = 30, $scale = 2)->default(0);
            $table->decimal('ledger', $precision = 30, $scale = 2)->default(0);
            $table->string('bank_name');
            $table->string('account_number')->unique();
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
        Schema::dropIfExists('wallets');
    }
}
