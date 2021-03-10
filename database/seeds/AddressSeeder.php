<?php

use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$addresses = [
			[
				'location' => 'Municipio San Jose',
				'street' => 'Calle 132 Los Mijaos',
				'zip_code' => '2001',
				'country_id' => 1,
				'state_id' => 7,
				'city_id' => 115
			],
			[
				'location' => 'Delray beach',
				'street' => 'Street 56th Flowers',
				'zip_code' => '305',
				'country_id' => 1,
				'state_id' => 26,
				'city_id' => 499
			],
		];

		DB::table('addresses')->insert($addresses);
	}
}
