<?php

namespace Modules\HR\Http\Requests\Update;

use Modules\HR\Entities\JobCircular;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateJobCircularRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('job_circular_edit');
    }

    public function rules()
    {
        return [
            'name'            => [
                'string',
                'required',
            ],
            'vacancy_no'      => [
                'string',
                'nullable',
            ],
            'posted_date'     => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'employment_type' => [
                'required',
            ],
            'experience'      => [
                'string',
                'nullable',
            ],
            'age'             => [
                'string',
                'nullable',
            ],
            'salary_range'    => [
                'string',
                'nullable',
            ],
            'last_date'       => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'permissions.*'   => [
                'integer',
            ],
            'permissions'     => [
                'array',
            ],
        ];
    }
}
