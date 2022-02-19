<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Sufi Surf 3 gram',
                'purchase_qty' => 50,
                'purchase_rate' => 70,
                'sale_rate' => 80,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Sufi Soap',
                'purchase_qty' => 50,
                'purchase_rate' => 20,
                'sale_rate' => 30,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Sufi Oil',
                'purchase_qty' => 50,
                'purchase_rate' => 100,
                'sale_rate' => 110,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
