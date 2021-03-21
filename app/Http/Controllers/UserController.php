<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return User::with('orders:id,user_id,name')->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required | unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors())->setStatusCode(422, 'Validation error');
        }
        $user = User::create($request->all());
        return response()->json([
            'user_id' => $user->id
        ]);
    }
}
