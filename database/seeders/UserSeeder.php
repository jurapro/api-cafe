<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
            'password' => 'admin',
            'role_id' => Role::where('code', 'admin')->first()->id,
        ]);

        User::factory()->create([
            'login' => 'waiter',
            'password' => 'waiter',
            'role_id' => Role::where('code', 'waiter')->first()->id,
        ]);

        User::factory()->create([
            'login' => 'cook',
            'password' => 'cook',
            'role_id' => Role::where('code', 'cook')->first()->id,
        ]);
    }
}
