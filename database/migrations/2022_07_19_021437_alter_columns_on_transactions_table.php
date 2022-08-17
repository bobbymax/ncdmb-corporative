<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsOnTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('transactionable_id');
            $table->dropColumn('transactionable_type');
            $table->dropColumn('code');
            $table->bigInteger('user_id')->default(0)->after('id');
            $table->string('trnxId')->unique()->nullable()->after('user_id');
            $table->longText('description')->nullable()->after('amount');
            $table->enum('category', ['debit', 'credit'])->default('debit')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->bigInteger('transactionable_id')->unsigned()->after('id');
            $table->string('transactionable_type')->nullable()->after('transactionable_id');
            $table->string('code')->nullable()->after('transactionable_type');
            $table->dropColumn('user_id');
            $table->dropColumn('trnxId');
            $table->dropColumn('description');
            $table->dropColumn('category');
        });
    }
}
