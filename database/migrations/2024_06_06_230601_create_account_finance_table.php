<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountFinanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_finance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->string('bill_no');
            $table->string('product_name')->nullable();
            $table->date('bill_date')->nullable();
            $table->double('total_amount', 10, 2);
            $table->double('amount_paid', 10, 2);
            $table->double('amount_remaining', 10, 2);
            $table->string('payable_by')->nullable();
            $table->string('payable_to')->nullable();
            $table->string('remarks')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('account_finance');
    }
}
