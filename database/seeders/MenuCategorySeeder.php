<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_categories')->insert([
            ['name' => 'Основные блюда'],
            ['name' => 'Напитки'],
            ['name' => 'Десерты']
        ]);
    }
}
