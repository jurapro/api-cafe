<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors())->setStatusCode(422, 'Validation error'));
    }

    public function messages()
    {
        $messages = parent::messages();
        $messages += [
            'unique' => ':attribute должен быть уникальным',
            'required'=>'Атрибут :attribute должен быть не пустым'
        ];
        return $messages;
    }

}
