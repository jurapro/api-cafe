<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (!User::find($id)) throw new ApiException(404, 'Not found');
        return new UserResource(User::find($id));
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
        if (!$user) throw new ApiException(404, 'Not found');
        $user->status = 'fired';
        $user->save();
        return new UserResource($user);
    }

}
