<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsOnJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->bigInteger('chart_of_account_id')->default(0)->after('account_code_id');
            $table->dropColumn('name');
            $table->dropColumn('entry_date');
            $table->dropColumn('payment_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn('chart_of_account_id');
            $table->string('name')->after('budget_head_id');
            $table->date('entry_date')->nullable()->after('name');
            $table->enum('payment_type', ['credit', 'debit'])->default('debit')->after('description');
        });
    }
}
