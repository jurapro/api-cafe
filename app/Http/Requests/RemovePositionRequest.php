<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RemovePositionRequest extends ApiRequest
{
    public function authorize()
    {
        $order = $this->route('order');

        if (!$order->worker->workShift->active) {
            throw new ApiException(403, 'You cannot change the order status of a closed shift!');
        }

        if ($order->worker->user->id !== Auth::user()->id) {
            throw new ApiException(403, 'Forbidden! You did not accept this order!');
        }

        if ($order->status->code !== 'taken') {
            throw new ApiException(403, 'Forbidden! Cannot be added to an order with this status');
        }

        return true;
    }

    public function rules()
    {
        return [

        ];
    }
}
