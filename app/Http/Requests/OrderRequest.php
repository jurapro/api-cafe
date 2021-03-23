<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends ApiRequest
{
     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'from' => 'required',
            'to' => 'required',
            'user_id' => 'required | integer | exists:users,id',
        ];
    }

    public function messages()
    {
        $messages = parent::messages();
        $messages += [
            'user_id.exists' => 'Пользователь не найден',
        ];
        return $messages;
    }


}
