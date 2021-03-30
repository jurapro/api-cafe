<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use App\Models\WorkShift;
use Illuminate\Foundation\Http\FormRequest;

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
