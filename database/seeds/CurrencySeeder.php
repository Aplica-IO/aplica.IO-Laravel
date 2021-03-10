<?php

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currency = [
            ['name' => 'USD'],
            ['name' => 'BsS.'],
        ];
        DB::table('currencies')->insert($currency);
    }
}
