<?php

namespace App\Http\Requests;

use App\Models\Stock;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStockRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('stock_create');
    }

    public function rules()
    {
        return [
            'stock_sub_category_id' => [
                'required',
                'integer',
            ],
            'name'                  => [
                'string',
                'required',
                'unique:stocks',
            ],
            'total_stock'           => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
