<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit = $this->command->ask('Please enter the limit for creating');
        $group = $this->command->ask('Please enter the name group for creating');

        User::factory($limit)->create([
            'password' => 'admin',
            'role_id' => Role::where('code', 'admin')->first()->id,
        ])->each(function ($user, $key) use ($group) {
            $user->login = $group . '_' . ($key+1) . '_admin';
            $user->save();
        });

        User::factory($limit)->create([
            'password' => 'waiter',
            'role_id' => Role::where('code', 'waiter')->first()->id,
        ])->each(function ($user, $key) use ($group) {
            $user->login = $group . '_' . ($key+1) . '_waiter';
            $user->save();
        });

        User::factory($limit)->create([
            'password' => 'cook',
            'role_id' => Role::where('code', 'cook')->first()->id,
        ])->each(function ($user, $key) use ($group) {
            $user->login = $group . '_' . ($key+1) . '_cook';
            $user->save();
        });

    }
}
