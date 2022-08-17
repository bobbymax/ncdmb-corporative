<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsOnServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('request_date');
            $table->dropColumn('serviceCode');
            $table->dropColumn('payment_method');
            $table->dropColumn('category');
            $table->bigInteger('service_category_id')->default(0)->after('user_id');
            $table->string('code')->unique()->nullable()->after('service_category_id');
            $table->enum('method_of_payment', ['upfront', 'salary', 'deposit', 'other'])->default('salary')->after('description');
            $table->string('other')->nullable()->after('method_of_payment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->date('request_date')->nullable()->after('description');
            $table->string('serviceCode')->unique()->nullable()->after('user_id');
            $table->string('payment_method')->nullable()->after('request_date');
            $table->string('category')->default('undefined')->after('serviceCode');
            $table->dropColumn('service_category_id');
            $table->dropColumn('code');
            $table->dropColumn('method_of_payment');
            $table->dropColumn('other');
        });
    }
}
