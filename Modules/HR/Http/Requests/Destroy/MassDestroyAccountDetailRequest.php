<?php

namespace Modules\HR\Http\Requests\Destroy;

use Modules\HR\Entities\AccountDetail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAccountDetailRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('account_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:account_details,id',
        ];
    }
}
