<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->decimal('previousAmount', $precision = 30, $scale = 2)->default(0)->after('amount');
            $table->decimal('capitalSum', $precision = 30, $scale = 2)->default(0)->after('description');
            $table->decimal('committment', $precision = 30, $scale = 2)->default(0)->after('capitalSum');
            $table->decimal('interestSum', $precision = 30, $scale = 2)->default(0)->after('committment');
            $table->decimal('totalPayable', $precision = 30, $scale = 2)->default(0)->after('interestSum');
            $table->boolean('active')->default(false)->after('totalPayable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('capitalSum');
            $table->dropColumn('committment');
            $table->dropColumn('interestSum');
            $table->dropColumn('totalPayable');
            $table->dropColumn('active');
        });
    }
}
