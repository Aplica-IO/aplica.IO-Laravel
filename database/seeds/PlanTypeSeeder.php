<?php

use Illuminate\Database\Seeder;

class PlanTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'Basico'
            ],
            [
                'name' => 'Medio'
            ],
            [
                'name' => 'Avanzado'
            ],
            [
                'name' => 'Premium'
            ],
        ];

        DB::table('plan_types')->insert($types);
    }
}
