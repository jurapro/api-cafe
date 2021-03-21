<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'from' => 'required',
            'to' => 'required',
            'user_id' => 'required | integer | exists:users,id',
        ], [
            'user_id.exists' => 'User not found',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors())->setStatusCode(422, 'Validation error');
        }
        $order = Order::create($request->all());
        return response()->json([
            'order_id' => $order->id
        ]);
    }
}
