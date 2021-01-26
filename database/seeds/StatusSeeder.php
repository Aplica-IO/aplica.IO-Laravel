<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['name' => 'Emitida'],
            ['name' => 'Pagada'],
            ['name' => 'Anulada'],
            ['name' => 'Abono'],
            ['name' => 'Incompleta'],
        ];

        DB::table('status')->insert($status);
    }
}
