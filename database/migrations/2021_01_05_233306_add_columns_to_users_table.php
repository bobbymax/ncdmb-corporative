<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('membership_no')->unique()->nullable()->after('id');
            $table->string('staff_no')->unique()->nullable()->after('membership_no');
            $table->string('designation')->nullable()->after('staff_no');
            $table->string('middlename')->nullable()->after('firstname');
            $table->string('surname')->after('middlename');
            $table->bigInteger('mobile')->unique()->nullable()->after('email');
            $table->enum('type', ['member', 'exco'])->default('member')->after('mobile');
            $table->date('date_joined')->nullable()->after('type');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('date_joined');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('membership_no');
            $table->dropColumn('staff_no');
            $table->dropColumn('designation');
            $table->dropColumn('middlename');
            $table->dropColumn('surname');
            $table->dropColumn('mobile');
            $table->dropColumn('type');
            $table->dropColumn('date_joined');
            $table->dropColumn('status');
        });
    }
}
