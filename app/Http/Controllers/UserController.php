<?php

namespace App\Http\Controllers;
use App\Http\Requests\User\DismissUserRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Resources\UserAllResource;
use App\Http\Resources\UserResource;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        return [
            'data' => [
                'user_token' => User::where(['login' => $request->login])->first()->generateToken()
            ]
        ];
    }

    public function logout()
    {
        Auth::user()->logout();
        return [
            'data' => [
                'message' => 'logout'
            ]
        ];
    }

    public function index()
    {
        return UserAllResource::collection(User::all());
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function store(RegisterUserRequest $userRequest)
    {
        $user = User::create([
                'password' => $userRequest->password,
                'photo_file' => $userRequest->photo_file ? $userRequest->photo_file->store('public') : null,
            ] + $userRequest->all()
        );

        return response()->json([
            'data' => [
                'id' => $user->id,
                'status' => 'created'
            ]
        ])->setStatusCode(201, 'Created');
    }

    public function toDismiss(User $user, DismissUserRequest $dismissUserRequest)
    {
        return [
            'data' => [
                'id' => $user->toDismiss()->id,
                'status' => 'fired'
            ]
        ];
    }

}
