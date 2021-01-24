<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('label')->unique();
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->decimal('amount', $precision = 30, $scale = 2)->default(0);
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->integer('period')->default(0);
            $table->enum('status', ['pending', 'approved', 'running', 'closed'])->default('pending');
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('budgets');
    }
}
