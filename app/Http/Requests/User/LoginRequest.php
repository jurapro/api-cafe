<?php

namespace App\Http\Requests\User;
use App\Http\Requests\ApiRequest;
use App\Models\User;

class LoginRequest extends ApiRequest
{
    public function authorize()
    {
        return User::where('login', $this->login)
            ->where('password', $this->password)
            ->where('status', 'working')->first();
    }

    public function rules()
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }
}
