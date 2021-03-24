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
            'password' => Hash::make('admin'),
            'role_id' => Role::where('code', 'admin')->first()->id,
        ]);

        User::factory()->create([
            'login' => 'waiter',
            'password' => Hash::make('waiter'),
            'role_id' => Role::where('code', 'waiter')->first()->id,
        ]);

        User::factory()->create([
            'login' => 'cook',
            'password' => Hash::make('cook'),
            'role_id' => Role::where('code', 'cook')->first()->id,
        ]);

        User::factory()->count(4)->create([
            'role_id' => Role::where('code', 'waiter')->first()->id,
        ]);

        User::factory()->count(2)->create([
            'role_id' => Role::where('code', 'cook')->first()->id,
        ]);
    }
}
