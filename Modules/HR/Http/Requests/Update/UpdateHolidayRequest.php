<?php

namespace Modules\HR\Http\Requests\Update;

use Modules\HR\Entities\Holiday;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHolidayRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('holiday_edit');
    }

    public function rules()
    {
        return [
            'name'       => [
                'string',
                'required',
            ],
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'end_date'   => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'color'   => [
                'string',
                'nullable',
            ],
        ];
    }
}
