<?php


namespace Modules\Sales\Http\Requests\Store;

use Modules\Sales\Entities\ProposalsItem;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProposalsItemRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('proposals_item_create');
    }

    public function rules()
    {
        return [
            'proposals_id'     => [
                'required',
                'integer',
            ],
            'name'             => [
                'string',
                'required',
                'unique:proposals_items',
            ],
            'group_name'       => [
                'string',
                'nullable',
            ],
            'brand'            => [
                'string',
                'nullable',
            ],
            'delivery'         => [
                'string',
                'required',
            ],
            'part'             => [
                'string',
                'required',
            ],
            'quantity'         => [
                'numeric',
            ],
            'unit_cost'        => [
                'numeric',
            ],
            'margin'           => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'total_cost_price' => [
                'required',
            ],
            'tax_rate'         => [
                'numeric',
                'required',
            ],
            'tax_name'         => [
                'string',
                'nullable',
            ],
            'order'            => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'unit'             => [
                'string',
                'required',
            ],
            'hsn_code'         => [
                'string',
                'nullable',
            ],
        ];
    }
}
