<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisbursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disbursements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned(); // logged in user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('budget_head_id')->unsigned(); // editable dropdown
            $table->foreign('budget_head_id')->references('id')->on('budget_heads')->onDelete('cascade');
            $table->bigInteger('chart_of_account_id')->unsigned(); // editable dropdown
            $table->foreign('chart_of_account_id')->references('id')->on('chart_of_accounts')->onDelete('cascade');
            $table->enum('payment_type', ['member-payment', 'staff-payment', 'third-party', 'custom'])->default('member-payment');
            $table->enum('type', ['loan', 'expense', 'salary', 'contribution', 'dividend', 'other'])->default('other');
            $table->string('code')->unique();
            $table->string('beneficiary');
            $table->bigInteger('loan_id')->default(0);
            $table->bigInteger('bundle_id')->default(0);
            $table->text('description')->nullable(); // editable textbox
            $table->decimal('amount', $precision = 30, $scale = 2)->default(0); // editable
            $table->enum('status', ['pending', 'batched', 'paid'])->default('pending');
            $table->boolean('closed')->default(false);
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
        Schema::dropIfExists('disbursements');
    }
}
