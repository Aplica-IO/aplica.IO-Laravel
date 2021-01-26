<?php

use Illuminate\Database\Seeder;

class ResidenceSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$residences = [
			[
				'name' => 'Doral Country Club',
				'nif' => 'ABCD1234',
				'address_id' => 1,
				'auditor_id' => 2,
				'community_type' => 1,
			],
			[
				'name' => 'El Paraiso',
				'nif' => 'DCBA4321',
				'address_id' => 2,
				'auditor_id' => 2,
				'community_type' => 1,
			],
		];

		DB::table('residences')->insert($residences);
	}
}
