<?php

namespace App\Http\Requests\Shift;

use App\Exceptions\ApiException;
use App\Http\Requests\ApiRequest;
use App\Models\WorkShift;

class OpenWorkShiftRequest extends ApiRequest
{
    public function authorize()
    {
        if (WorkShift::where(['active' => true])->count()) {
            return false;
        }

        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }

    protected function failedAuthorization()
    {
        throw new ApiException(403, 'Forbidden. There are open shifts!');
    }
}
