<?php

namespace App\Http\Requests;

use App\Models\TechnicalCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTechnicalCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('technical_category_create');
    }

    public function rules()
    {
        return [
            'beginner'      => [
                'string',
                'nullable',
            ],
            'intermediate'  => [
                'string',
                'nullable',
            ],
            'advanced'      => [
                'string',
                'nullable',
            ],
            'expert_leader' => [
                'string',
                'nullable',
            ],
        ];
    }
}
