<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInInvoiceProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_product', function (Blueprint $table) {
            $table->double('unit_price', 8, 2)->after('ctn_qty')->nullable();
            $table->double('ctn_price', 8, 2)->after('unit_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_product', function (Blueprint $table) {
            $table->dropColumn(['unit_price', 'ctn_price']);
        });
    }
}
