<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsOnEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn('entryable_id');
            $table->dropColumn('entryable_type');
            $table->text('description')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->bigInteger('entryable_id')->unsigned()->after('amount');
            $table->string('entryable_type')->after('entryable_id');
            $table->dropColumn('description');
        });
    }
}
