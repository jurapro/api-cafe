<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShowOrderRequest extends ApiRequest
{
    public function authorize()
    {
        $order = $this->route('order');

        if (Auth::user()->hasRole(['admin']) || $order->worker->user->id === Auth::user()->id) {
            return true;
        }
        return false;
    }

    public function rules()
    {
        return [
            //
        ];
    }

    protected function failedAuthorization()
    {
        throw new ApiException(403, 'Forbidden. You did not accept this order!');
    }
}
