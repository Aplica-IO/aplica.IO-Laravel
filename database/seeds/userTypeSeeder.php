<?php

use Illuminate\Database\Seeder;

class userTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['name' => 'Admin'],
            ['name' => 'Auditor'],
            ['name' => 'Usuario'],
        ];

        DB::table('types')->insert($types);
    }
}
