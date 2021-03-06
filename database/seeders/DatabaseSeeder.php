<?php

namespace Database\Seeders;

use App\Models\ShiftWorker;
use App\Models\WorkShift;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            MenuCategorySeeder::class,
            MenuSeeder::class,
            TableSeeder::class,
            StatusOrderSeeder::class,
            WorkShiftSeeder::class,
            ShiftWorkerSeeder::class,
            OrderSeeder::class,
            OrderMenuSeeder::class
        ]);
    }
}
