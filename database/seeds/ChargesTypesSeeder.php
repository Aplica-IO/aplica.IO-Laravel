<?php

use Illuminate\Database\Seeder;

class ChargesTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $charge_types = [
            ['charge_name' => 'Gastos comunes'],
            ['charge_name' => 'Gastos no comunes'],
            ['charge_name' => 'Gastos Personales'],
        ];
        DB::table('charges_types')->insert($charge_types);
    }
}
