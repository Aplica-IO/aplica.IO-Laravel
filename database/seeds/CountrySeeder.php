<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
	    $countries = [
            ['name' => 'Venezuela'],
            // ['name' => 'Estados Unidos'],
        ];
		DB::table('countries')->insert($countries);
	}
}
