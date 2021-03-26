<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = array_map(function ($n) {
            return [
                'name' => "Столик №$n",
                'capacity' => rand(2,10)
            ];
        }, range(1, 10));

        DB::table('tables')->insert($tables);
    }
}
