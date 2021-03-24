<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {

        if ($user = User::query()->where(['login' => $request->login])->first()
            and Hash::check($request->password, $user->password)) {
            return response()->json([
                'data' => [
                    'user_token' => $user->generateToken()
                ]
            ]);
        }

        throw new ApiException(401,'Authentication failed');
    }

  public function index()
    {
        return response()->json([
            'data' => User::all(['id','name','login','status','role_id'])->append('group')
        ]);
    }

/*
    public function store(UserRequest $request)
    {
        $user = User::create($request->all());
        return response()->json([
            'user_id' => $user->id
        ]);
    }*/
}
