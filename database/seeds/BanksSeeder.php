<?php

use Illuminate\Database\Seeder;

class BanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            ['bank' => 'Mercantil'],
            ['bank' => 'BOD'],
            ['bank' => 'Fondo Comun'],
            ['bank' => 'Banesco'],
            ['bank' => 'Banco de Venezuela'],
            ['bank' => 'Banco agricola'],
            ['bank' => 'BNC'],
            ['bank' => 'Banco del Tesoro'],
            ['bank' => 'Bancamiga'],
            ['bank' => 'Otro'],
        ];
        DB::table('banks')->insert($banks);
    }
}
