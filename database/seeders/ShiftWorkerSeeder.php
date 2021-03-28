<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WorkShift;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftWorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (WorkShift::all() as $shift) {
            foreach (User::all() as $user) {
                DB::table('shift_workers')->insert([
                    'work_shift_id'=>$shift->id,
                    'user_id'=>$user->id
                ]);
            }
        }
    }
}
