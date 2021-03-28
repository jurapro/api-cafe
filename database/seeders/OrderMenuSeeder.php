<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Order::all() as $order) {
            foreach (Menu::all()->random(rand(1, 5)) as $position) {
                DB::table('order_menus')->insert([
                    'menu_id' => $position->id,
                    'order_id' => $order->id,
                    'count' => rand(1, 3)
                ]);
            }
        }
    }
}
