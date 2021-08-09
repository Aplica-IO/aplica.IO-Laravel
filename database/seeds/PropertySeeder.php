<?php

use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$properties = [
			[
				'reference' => 'A-1',
                'balance' => 0,
				'alicuota' => 1.75,
				'is_active' => true,
				'residence_id' => 1,
				'user_id' => 3,
			],
			[
                'reference' => 'A-2',
                'balance' => 0,
				'alicuota' => 3.25,
				'is_active' => true,
				'residence_id' => 1,
				'user_id' => 4,
			],
		];

		DB::table('properties')->insert($properties);
	}
}
