<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'surname' => 'string',
            'patronymic' => 'string',
            'login' => 'required|string|unique:users',
            'password' => 'required|string',
            'photo_file' => 'image|mimes:jpg,jpeg,png',
            'role_id' => 'required|integer|exists:users,id',
        ];
    }
}
