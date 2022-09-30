<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booker_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('salesman_name')->nullable();
            $table->string('area_name')->nullable();
            $table->string('status')->nullable();
            $table->double('total', 8, 2);
            $table->double('less_trade_offer')->nullable();
            $table->double('less_percentage_discount')->nullable();
            $table->double('net_total', 8, 2)->nullable();
            $table->timestamps();
            $table->foreign('booker_id')->references('id')->on('bookers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}
