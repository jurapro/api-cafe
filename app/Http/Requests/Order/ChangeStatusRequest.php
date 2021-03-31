<?php

namespace App\Http\Requests\Order;

use App\Exceptions\ApiException;
use App\Http\Requests\ApiRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChangeStatusRequest extends ApiRequest
{

    public function authorize()
    {
        $order = $this->route('order');

        if (!$order->worker->workShift->active) {
            throw new ApiException(403, 'You cannot change the order status of a closed shift!');
        }
        if ($this->user()->cannot('changeStatus-order', $order)) {
            throw new ApiException(403, 'Forbidden! You did not accept this order!');
        }
        if ($this->user()->cannot('allowStatus-order', [$order, $this->status])) {
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
