<?php

namespace App\Http\Requests;

use App\Rules\OrderRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'work_shift_id' => 'required|exists:work_shifts,id',
            'table_id' => 'required|exists:tables,id',
            'number_of_person' => 'integer'
        ];
    }
}
