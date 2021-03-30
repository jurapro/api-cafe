<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Foundation\Http\FormRequest;

class DismissUserRequest extends FormRequest
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
