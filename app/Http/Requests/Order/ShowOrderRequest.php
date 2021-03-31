<?php

namespace App\Http\Requests\Order;

use App\Exceptions\ApiException;
use App\Http\Requests\ApiRequest;
use Illuminate\Support\Facades\Auth;

class ShowOrderRequest extends ApiRequest
{
    public function authorize()
    {
        $order = $this->route('order');
        return $this->user()->can('show-order', $order);
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
