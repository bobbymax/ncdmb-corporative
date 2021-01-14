<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('restriction')->default(0)->after('fundable');
            $table->enum('payable', ['undefined', 'contribution', 'salary', 'upfront'])->default('undefined')->after('restriction');
            $table->integer('committment')->default(0)->after('payable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('restriction');
            $table->dropColumn('payable');
            $table->dropColumn('committment');
        });
    }
}
