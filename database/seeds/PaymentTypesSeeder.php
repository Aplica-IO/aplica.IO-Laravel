<?php

use Illuminate\Database\Seeder;

class PaymentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['method' => 'Dolares en efectivo'],
            ['method' => 'Transferencia Zelle'],
            ['method' => 'Transferencia'],
            ['method' => 'Efectivo'],
            ['method' => 'Pago Movil'],
            ['method' => 'Otro'],
        ];
        DB::table('payment_methods')->insert($types);
    }
}
