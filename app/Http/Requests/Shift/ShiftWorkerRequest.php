<?php

namespace App\Http\Requests\Shift;

use App\Exceptions\ApiException;
use App\Http\Requests\ApiRequest;
use App\Rules\WorkingUserRule;

class ShiftWorkerRequest extends ApiRequest
{

    public function authorize()
    {
        $workShift = $this->route('workShift');

        if ($workShift->hasUser($this->user_id)) {
            return false;
        }

        return true;
    }

    public function rules()
    {
        return [
            'user_id' => ['required', new WorkingUserRule()]
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'User',
        ];
    }

    protected function failedAuthorization()
    {
        throw new ApiException(403, 'Forbidden. The worker is already on shift!');
    }
}
