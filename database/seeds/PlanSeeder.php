<?php

use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'time' => '1 mes',
                'price' => 10,
                'plan_type_id' => 1 
            ],
            [
                'time' => '3 meses',
                'price' => 28,
                'plan_type_id' => 2
            ],
            [
                'time' => '6 meses',
                'price' => 55,
                'plan_type_id' => 3
            ],
            [
                'time' => '1 año',
                'price' => 105,
                'plan_type_id' => 4
            ],
        ];

        DB::table('plans')->insert($plans);
    }
}
