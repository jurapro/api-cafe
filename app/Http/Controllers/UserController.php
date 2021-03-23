<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        return User::with('orders:id,user_id,name')->get();
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->all());
        return response()->json([
            'user_id' => $user->id
        ]);
    }
}
