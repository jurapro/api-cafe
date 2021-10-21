<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\AddOrderRequest;
use App\Http\Requests\Order\AddPositionRequest;
use App\Http\Requests\Order\ChangeStatusRequest;
use App\Http\Requests\Order\RemovePositionRequest;
use App\Http\Requests\Order\ShowOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersDetailResource;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderMenu;
use App\Models\StatusOrder;
use App\Models\WorkShift;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {
        return OrderResource::collection(Order::all());
    }

    public function store(AddOrderRequest $request)
    {
        $order = Order::create([
            'table_id' => $request->table_id,
            'number_of_person' => $request->number_of_person,
            'shift_worker_id' => Auth::user()->getShiftWorker($request->work_shift_id)->id,
            'status_order_id' => StatusOrder::where(['code' => 'taken'])->first()->id
        ]);

        return new OrderResource($order);
    }

    public function show(Order $order, ShowOrderRequest $showOrderRequest)
    {
        return new OrdersDetailResource($order);
    }


    public function changeStatus(Order $order, ChangeStatusRequest $changeStatusRequest)
    {
        $order->changeStatus($changeStatusRequest->status);

        return [
            'data' => [
                'id' => $order->id,
                'status' => $changeStatusRequest->status
            ]
        ];
    }

    public function takenOrders()
    {
        $orders = WorkShift::where(['active' => true])
            ->first()
            ->orders
            ->filter(function ($order) {
                return in_array($order->status->code, ['preparing', 'taken']);
            });

        return OrderResource::collection($orders);
    }

    public function addPosition(Order $order, AddPositionRequest $addPositionRequest)
    {
        OrderMenu::create([
            'order_id' => $order->id,
            'menu_id' => $addPositionRequest->menu_id,
            'count' => $addPositionRequest->count,
        ]);

        return new OrdersDetailResource($order);
    }

    public function removePosition(Order $order, OrderMenu $orderMenu, RemovePositionRequest $removePositionRequest)
    {
        $orderMenu->delete();
        return new OrdersDetailResource($order);
    }

    public function menu()
    {
        return Menu::all();
    }
}
