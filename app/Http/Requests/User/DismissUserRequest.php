<?php

namespace App\Http\Requests\User;

use App\Exceptions\ApiException;
use App\Http\Requests\ApiRequest;


class DismissUserRequest extends ApiRequest
{
    public function authorize()
    {
        $user = $this->route('user');

        if ($user->status === 'fired') {
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
        throw new ApiException(403, 'Forbidden. The user is already fired!');
    }
}
