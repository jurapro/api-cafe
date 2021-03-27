<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_of_person',
        'table_id',
        'status_order_id',
        'shift_worker_id'
    ];


    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function status()
    {
        return $this->belongsTo(StatusOrder::class, 'status_order_id');
    }

    public function worker()
    {
        return $this->belongsTo(ShiftWorker::class,'shift_worker_id');
    }

    public function positions()
    {
        return $this->hasMany(OrderMenu::class);
    }

    public function getPrice()
    {
        $price = 0;
        foreach ($this->positions as $item) {
            $price += $item->count * $item->product->price;
        }
        return $price;
    }

}
