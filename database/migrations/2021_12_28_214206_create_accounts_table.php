<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank');
            $table->string('account_number')->unique();
            $table->string('account_name');
            $table->string('sort_code')->nullable();

            $table->decimal('wallet', $precision = 30, $scale = 2)->default(0);
            $table->enum('entity', ['staff', 'organization', 'vendor'])->default('organization');

            $table->bigInteger('accountable_id')->unsigned();
            $table->string('accountable_type');
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
        Schema::dropIfExists('accounts');
    }
}
