<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\FoundRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;

use App\Http\Resources\UserResource;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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

        throw new ApiException(401, 'Authentication failed');
    }

    public function logout()
    {
        Auth::user()->logout();
        return response()->json()->setStatusCode(200, 'OK');
    }

    public function index()
    {
        return response()->json([
            'data' => User::all(['id', 'name', 'login', 'status', 'role_id'])
        ]);
    }

    public function show($id)
    {
        if (!$user = User::find($id)) {
            throw new ApiException(404, 'Not found');
        }
        return new UserResource($user);
    }

    public function store(UserRequest $userRequest)
    {
        $path = $userRequest->photo_file->store('public');

        $user = User::create([
                'password' => Hash::make($userRequest->password),
                'photo_file' => $path,
            ] + $userRequest->all()
        );

        return response()->json(['id' => $user->id])->setStatusCode(201, 'Created');
    }

    public function toDismiss($id)
    {
        $user = User::find($id);
        if (!$user) {
            throw new ApiException(404, 'Not found');
        }
        if ($user->status==='fired')  {
            throw new ApiException(403, 'Forbidden. The user is already fired!');
        }
        return new UserResource($user->toDismiss());
    }


}
