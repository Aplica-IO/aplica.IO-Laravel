<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResidencesTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['name' => 'Residencias'],
            ['name' => 'Centro Comerciales'],
            ['name' => 'Centro Medicos'],
            ['name' => 'Complejos Industriales'],
            ['name' => 'Aeropuerto'],
        ];
        DB::table('residences_type')->insert($types);
    }
}
