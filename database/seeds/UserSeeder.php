<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$users = [
			[
				'first_name' => 'Jose',
				'last_name' => 'Pineda',
				'type_dni' => 'Cedula',
				'dni' => '27.550.155',
				'password' => bcrypt('secret'),
				'type_id' => 1,
				'is_active' => true,
				'email' => 'admin@gmail.com',
			],
			[
				'first_name' => 'William',
				'last_name' => 'Gonzalez',
				'type_dni' => 'Cedula',
				'dni' => '28.211.592',
				'password' => bcrypt('secret'),
				'type_id' => 2,
				'is_active' => true,
				'email' => 'auditor@gmail.com',
			],
			[
				'first_name' => 'Raul',
				'last_name' => 'Castro',
				'type_dni' => 'Cedula',
				'dni' => '29.295.124',
				'password' => bcrypt('secret'),
				'type_id' => 3,
				'is_active' => true,
				'email' => 'raul@gmail.com',
			],
			[
				'first_name' => 'Luis',
				'last_name' => 'Miranda',
				'type_dni' => 'Cedula',
				'dni' => '18.293.142',
				'password' => bcrypt('secret'),
				'type_id' => 3,
				'is_active' => true,
				'email' => 'luis@gmail.com',
			],
		];

		DB::table('users')->insert($users);
	}
}
