<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class LoginRequest extends ApiRequest
{
    public function authorize()
    {
        if ($user = User::where(['login' => $this->login])->first()
            and $this->password === $user->password
            and $user->status === 'working') {
            return true;
        }
        return false;
    }

    public function rules()
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }
}
