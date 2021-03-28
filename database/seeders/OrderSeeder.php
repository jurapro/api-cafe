<?php

namespace Database\Seeders;

use App\Models\ShiftWorker;
use App\Models\StatusOrder;
use App\Models\Table;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shiftWorkerWaiters = ShiftWorker::all()->filter(function ($worker) {
            return $worker->user->role->code === 'waiter';
        });
        foreach ($shiftWorkerWaiters as $waiter) {
            foreach (StatusOrder::all() as $status) {
                DB::table('orders')->insert([
                    'table_id'=>Table::all()->random()->id,
                    'shift_worker_id'=>$waiter->id,
                    'status_order_id'=>$status->id,
                    'number_of_person'=>rand(1,10)
                ]);
            }
        }
    }
}
