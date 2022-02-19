<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class StockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stocks')->insert([
            [
                'product_id' => 1,
                'sale_qty' => 0,
                'in_stock' => 50,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'product_id' => 2,
                'sale_qty' => 0,
                'in_stock' => 50,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'product_id' => 3,
                'sale_qty' => 0,
                'in_stock' => 50,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
