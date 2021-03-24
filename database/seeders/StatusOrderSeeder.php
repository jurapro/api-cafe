<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_orders')->insert([
            [
                'name' => 'Принят',
                'code' => 'taken',
            ], [
                'name' => 'Готовится',
                'code' => 'preparing',
            ],
            [
                'name' => 'Готов',
                'code' => 'ready',
            ],
            [
                'name' => 'Оплачен',
                'code' => 'paid-up',
            ],
            [
                'name' => 'Отменен',
                'code' => 'canceled',
            ]
        ]);
    }
}
