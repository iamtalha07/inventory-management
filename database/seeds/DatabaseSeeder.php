<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        return $this->call(UserTableSeeder::class);
        // return  $this->call([UserTableSeeder::class,ProductTableSeeder::class,StockTableSeeder::class]);

    }
}
