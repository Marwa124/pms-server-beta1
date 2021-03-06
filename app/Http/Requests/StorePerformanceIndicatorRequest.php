<?php

namespace App\Http\Requests;

use App\Models\PerformanceIndicator;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePerformanceIndicatorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('performance_indicator_create');
    }

    public function rules()
    {
        return [
            'designation_id'           => [
                'required',
                'integer',
            ],
            'ability_to_meet_deadline' => [
                'string',
                'nullable',
            ],
        ];
    }
}
