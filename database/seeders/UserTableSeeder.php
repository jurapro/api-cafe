<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'login' => 'admin',
            'password' => Hash::make('admin'),
            'role_id' => Role::where('code', 'waiter')->first()->id,
        ]);

        User::factory()->count(10)->create([
            'role_id' => Role::where('code', 'waiter')->first()->id,
        ]);

        User::factory()->count(3)->create([
            'role_id' => Role::where('code', 'cook')->first()->id,
        ]);
    }
}
