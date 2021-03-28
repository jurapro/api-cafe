<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\AccessOrderRequest;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\PositionRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersDetailResource;
use App\Models\MenuCategory;
use App\Models\Order;
use App\Models\OrderMenu;
use App\Models\ShiftWorker;
use App\Models\StatusOrder;
use App\Models\WorkShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    public function changeStatusForWaiter(Order $order, ChangeStatusRequest $changeStatusRequest)
    {
        if (!$order->worker->workShift->active) {
            throw new ApiException(403, 'You cannot change the order status of a closed shift!');
        }

        if (Auth::user()->id !== $order->worker->user->id) {
            throw new ApiException(403, 'Forbidden! You did not accept this order!');
        }

        $order->changeStatus($changeStatusRequest->status, [
            'taken' => 'canceled',
            'ready' => 'paid-up'
        ]);

        return [
            'data' => [
                'id' => $order->id,
                'status' => $changeStatusRequest->status
            ]
        ];
    }

    public function changeStatusForCook(Order $order, ChangeStatusRequest $changeStatusRequest)
    {
        $order->changeStatus($changeStatusRequest->status, [
            'taken' => 'preparing',
            'preparing' => 'ready'
        ]);

        return [
            'data' => [
                'id' => $order->id,
                'status' => $changeStatusRequest->status
            ]
        ];
    }

    public function takenOrders()
    {
        $ordersActiveShift = WorkShift::where(['active' => true])->first()->orders;

        $orders = $ordersActiveShift->filter(function ($order) {

            $status = StatusOrder::where(['code' => 'taken'])
                ->orWhere(['code' => 'preparing'])
                ->get()
                ->map(function ($item) {
                    return $item->id;
                })->toArray();

            return in_array($order->status_order_id, $status);
        });


        return OrderResource::collection($orders);
    }

    public function addPosition(Order $order, PositionRequest $positionRequest)
    {
        if (Auth::user()->id !== $order->worker->user->id) {
            throw new ApiException(403, 'Forbidden! You did not accept this order!');
        }

        if (!$order->worker->workShift->active) {
            throw new ApiException(403, 'Forbidden! You cannot change the order status of a closed shift!');
        }

        if ($order->status->code!=='taken' && $order->status->code!=='preparing') {
            throw new ApiException(403, 'Forbidden! Cannot be added to an order with this status');
        }

        OrderMenu::create([
            'order_id'=>$order->id,
            'menu_id'=>$positionRequest->menu_id,
            'count'=>$positionRequest->count,
        ]);

        return new OrdersDetailResource($order);
    }

    public function removePosition(Order $order, OrderMenu $orderMenu)
    {
        if (Auth::user()->id !== $order->worker->user->id) {
            throw new ApiException(403, 'Forbidden! You did not accept this order!');
        }

        if (!$order->worker->workShift->active) {
            throw new ApiException(403, 'Forbidden! You cannot change the order status of a closed shift!');
        }

        if ($order->status->code!=='taken') {
            throw new ApiException(403, 'Forbidden! Cannot be added to an order with this status');
        }

        $orderMenu->delete();

        return new OrdersDetailResource($order);
    }
}
