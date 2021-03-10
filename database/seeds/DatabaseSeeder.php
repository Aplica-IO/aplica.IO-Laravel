<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
		$this->call([
			CountrySeeder::class,
			StateSeeder::class,
			CitySeeder::class,
			userTypeSeeder::class,
			UserSeeder::class,
			ResidencesTypeSeeder::class,
			AddressSeeder::class,
			ResidenceSeeder::class,
			PropertySeeder::class,
			StatusSeeder::class,
			PaymentTypesSeeder::class,
			BanksSeeder::class,
			ChargesTypesSeeder::class,
			CurrencySeeder::class,
			PlanTypeSeeder::class,
			PlanSeeder::class,
		]);
	}
}
