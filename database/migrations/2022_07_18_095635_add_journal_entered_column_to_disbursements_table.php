<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJournalEnteredColumnToDisbursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disbursements', function (Blueprint $table) {
            $table->boolean('journal_entered')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disbursements', function (Blueprint $table) {
            $table->dropColumn('journal_entered');
        });
    }
}
