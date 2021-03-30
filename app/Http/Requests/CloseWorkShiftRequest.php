<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use App\Models\WorkShift;
use Illuminate\Foundation\Http\FormRequest;

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
