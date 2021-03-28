<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'menu_id' => 'required|exists:menus,id',
            'count' => 'required|integer|between:1,10'
        ];
    }

    public function messages()
    {
        $messages = parent::messages();
        $messages += [
            'menu_id.exists' => 'Item is not in the menu',
            'count.between' => 'The number of portions should be from 1 to 10'
        ];
        return $messages;
    }
}
