<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\AccessOrderRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersDetailResource;
use App\Models\Order;
use App\Models\ShiftWorker;
use App\Models\StatusOrder;
use App\Models\WorkShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {
        return OrderResource::collection(Order::all());
    }

    public function store(OrderRequest $request)
    {
        if (!WorkShift::where(['id' => $request->work_shift_id])->first()->active) {
            throw new ApiException(403, 'Forbidden. The shift must be active!');
        };

        if (!$shiftWorker = Auth::user()->getShiftWorker($request->work_shift_id)) {
            throw new ApiException(403, 'Forbidden. You don\'t work this shift!');
        };

        $order = Order::create([
            'table_id' => $request->table_id,
            'number_of_person' => $request->number_of_person,
            'shift_worker_id' => $shiftWorker->id,
            'status_order_id' => StatusOrder::where(['code' => 'taken'])->first()->id
        ]);

        return new OrderResource($order);
    }

    public function show(Order $order)
    {
        if (!Auth::user()->hasRole(['admin']) && !$order->worker()->where(['user_id' => Auth::user()->id])->count()) {
            throw new ApiException(403, 'Forbidden. You did not accept this order!');
        }

        return new OrdersDetailResource($order);
    }

    public function update(Request $request, $id)
    {
        //
    }

}
