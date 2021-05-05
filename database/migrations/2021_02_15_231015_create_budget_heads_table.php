<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_heads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('budget_id')->unsigned();
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('cascade'); // Editable
            $table->string('code')->unique()->nullable(); // Editable (text input)
            $table->string('description'); // Editable
            $table->string('category')->default('na'); // Editable (select)
            $table->integer('interest')->default(0); // Editable
            $table->integer('restriction')->default(0); // Editable
            $table->integer('commitment')->default(0); // Editable
            $table->decimal('limit', $precision = 30, $scale = 2)->default(0); // Editable
            $table->string('payable')->default('na'); // Editable (select)
            $table->string('frequency')->default('na'); // Editable (select)
            $table->enum('type', ['capital', 'recursive', 'personnel'])->default('capital'); // Editable (select)
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('budget_heads');
    }
}
