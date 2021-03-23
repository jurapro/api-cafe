<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'Администратор',
                'code' => 'admin',
            ], [
                'name' => 'Официант',
                'code' => 'waiter',
            ],
            [
                'name' => 'Повар',
                'code' => 'cook',
            ]
        ]);
    }
}
