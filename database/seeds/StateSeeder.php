<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            ['name' => 'Amazonas'],
            ['name' => 'Anzoátegui'],
            ['name' => 'Apure'],
            ['name' => 'Aragua'],
            ['name' => 'Barinas'],
            ['name' => 'Bolívar'],
            ['name' => 'Carabobo'],
            ['name' => 'Cojedes'],
            ['name' => 'Delta Amacuro'],
            ['name' => 'Falcón'],
            ['name' => 'Guárico'],
            ['name' => 'Lara'],
            ['name' => 'Mérida'],
            ['name' => 'Miranda'],
            ['name' => 'Monagas'],
            ['name' => 'Nueva Esparta'],
            ['name' => 'Portuguesa'],
            ['name' => 'Sucre'],
            ['name' => 'Táchira'],
            ['name' => 'Trujillo'],
            ['name' => 'Vargas'],
            ['name' => 'Yaracuy'],
            ['name' => 'Zulia'],
            ['name' => 'Distrito Capital'],
            ['name' => 'Dependencias Federales'],
            ['name' => 'Florida'],
        ];

        DB::table('states')->insert($states);
    }
}
