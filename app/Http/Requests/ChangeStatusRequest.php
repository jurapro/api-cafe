<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeStatusRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'status' => ['required',
                Rule::in(['taken', 'preparing', 'ready', 'paid-up', 'canceled'])]
        ];
    }

    public function messages()
    {
        $messages = parent::messages();
        $messages += [
            'in' => 'Status can only be: taken, preparing, ready, paid-up, canceled'
        ];
        return $messages;
    }
}
