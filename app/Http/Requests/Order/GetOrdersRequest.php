<?php

namespace App\Http\Requests\Order;

use App\Exceptions\ApiException;
use App\Http\Requests\ApiRequest;
use Illuminate\Support\Facades\Auth;

class GetOrdersRequest extends ApiRequest
{
    public function authorize()
    {
        $workShift = $this->route('workShift');

        if (Auth::user()->hasRole(['admin']) || $workShift->hasUser(Auth::user()->id))
        {
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
        throw new ApiException(403, 'Forbidden. You didn\'t work this shift!');
    }
}
