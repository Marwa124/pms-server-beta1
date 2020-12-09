@extends('layouts.admin')
@section('content')



<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.Countries_Code.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{route('sales.admin.countries.update',$country->id)}}" enctype="multipart/form-data">
                @method("PUT")
            @csrf

            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.Countries_Code.fields.Code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" value="{{$country->code}}" name="code" id="code" value="{{ old('code', '') }}" required>
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.Countries_Code.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>






@endsection