<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'number_of_person',
        'waiter_table_id',
        'status_order_id',
    ];


    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function status()
    {
        return $this->belongsTo(StatusOrder::class,'status_order_id');
    }

    public function user()
    {
        return $this->hasOneThrough(User::class,ShiftWorker::class,
            'id','id');
    }

    public function positions()
    {
        return $this->hasMany(OrderMenu::class);
    }

}
