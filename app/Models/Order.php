<?php

namespace App\Models;

use App\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        return $this->belongsTo(ShiftWorker::class, 'shift_worker_id');
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

    public function changeStatus($status)
    {
        if(!$this->worker->workShift->active) {
            throw new ApiException(403, 'You cannot change the order status of a closed shift!');
        }

        if (Auth::user()->hasRole(['waiter'])) {
            if (Auth::user()->id !== $this->worker->user->id) {
                throw new ApiException(403, 'Forbidden! You did not accept this order!');
            }

            $allowed = [
                'taken' => 'canceled',
                'ready' => 'paid-up'
            ];
        }

        if (Auth::user()->hasRole(['cook'])) {
            $allowed = [
                'taken' => 'preparing',
                'preparing' => 'ready'
            ];
        }

        if (empty($allowed[$this->status->code]) || $allowed[$this->status->code] !== $status) {
            throw new ApiException(403, 'Forbidden! Can\'t change existing order status');
        }

        $id_status = StatusOrder::where(['code' => $status])->first()->id;
        $this->status_order_id = $id_status;
        $this->save();
    }
}
