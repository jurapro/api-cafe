<?php

namespace App\Http\Requests\Shift;

use App\Exceptions\ApiException;
use App\Http\Requests\ApiRequest;

class CloseWorkShiftRequest extends ApiRequest
{
    public function authorize()
    {
        $workShift = $this->route('workShift');

        if ($workShift->active) {
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
        throw new ApiException(403, 'Forbidden. The shift is already closed!');
    }
}
