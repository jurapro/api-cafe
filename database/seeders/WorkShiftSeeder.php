<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('work_shifts')->insert([
            [
                'start'=>'2021-04-19 08:00:00',
                'end'=>'2021-04-19 18:00:00',
                'active'=>true
            ],
            [
                'start'=>'2021-04-20 08:00:00',
                'end'=>'2021-04-20 18:00:00',
                'active'=>false
            ],
            [
                'start'=>'2021-04-21 08:00:00',
                'end'=>'2021-04-21 18:00:00',
                'active'=>false
            ],
        ]);
    }
}
