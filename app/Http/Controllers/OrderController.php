<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersDetailResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        return OrderResource::collection(Order::all());
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Order $order)
    {
        return new OrdersDetailResource($order);
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
