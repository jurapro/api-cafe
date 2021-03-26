<?php

namespace App\Http\Requests;

use App\Rules\WorkingUserRule;
use Illuminate\Foundation\Http\FormRequest;

class ShiftWorkerRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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

}
