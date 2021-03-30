<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChangeStatusForCookRequest extends ApiRequest
{

    public function authorize()
    {
        $order = $this->route('order');

        if (!$order->worker->workShift->active) {
            throw new ApiException(403, 'You cannot change the order status of a closed shift!');
        }

        $allowed = [
            'taken' => 'preparing',
            'preparing' => 'ready'
        ];

        if (empty($allowed[$order->status->code]) || $allowed[$order->status->code] !== $this->status) {
            throw new ApiException(403, 'Forbidden! Can\'t change existing order status');
        }

        return true;
    }

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
