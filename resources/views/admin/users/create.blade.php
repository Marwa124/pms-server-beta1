@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.users.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <div class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="username">{{ trans('cruds.user.fields.username') }}</label>
                <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text" name="username" id="username" value="{{ old('username', '') }}">
                @if($errors->has('username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.username_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.user.fields.banned') }}</label>
                @foreach(App\Models\User::BANNED_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('banned') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="banned_{{ $key }}" name="banned" value="{{ $key }}" {{ old('banned', '0') === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="banned_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('banned'))
                    <div class="invalid-feedback">
                        {{ $errors->first('banned') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.banned_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="permissions">{{ trans('cruds.user.fields.permissions') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('permissions') ? 'is-invalid' : '' }}" name="permissions[]" id="permissions" multiple>
                    @foreach($permissions as $id => $permissions)
                        <option value="{{ $id }}" {{ in_array($id, old('permissions', [])) ? 'selected' : '' }}>{{ $permissions }}</option>
                    @endforeach
                </select>
                @if($errors->has('permissions'))
                    <div class="invalid-feedback">
                        {{ $errors->first('permissions') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.permissions_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="smtp_email_type">{{ trans('cruds.user.fields.smtp_email_type') }}</label>
                <input class="form-control {{ $errors->has('smtp_email_type') ? 'is-invalid' : '' }}" type="text" name="smtp_email_type" id="smtp_email_type" value="{{ old('smtp_email_type', '') }}">
                @if($errors->has('smtp_email_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('smtp_email_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.smtp_email_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="smtp_host_name">{{ trans('cruds.user.fields.smtp_host_name') }}</label>
                <input class="form-control {{ $errors->has('smtp_host_name') ? 'is-invalid' : '' }}" type="text" name="smtp_host_name" id="smtp_host_name" value="{{ old('smtp_host_name', '') }}">
                @if($errors->has('smtp_host_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('smtp_host_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.smtp_host_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="smtp_user_name">{{ trans('cruds.user.fields.smtp_user_name') }}</label>
                <input class="form-control {{ $errors->has('smtp_user_name') ? 'is-invalid' : '' }}" type="text" name="smtp_user_name" id="smtp_user_name" value="{{ old('smtp_user_name', '') }}">
                @if($errors->has('smtp_user_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('smtp_user_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.smtp_user_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="smtp_password">{{ trans('cruds.user.fields.smtp_password') }}</label>
                <input class="form-control {{ $errors->has('smtp_password') ? 'is-invalid' : '' }}" type="password" name="smtp_password" id="smtp_password">
                @if($errors->has('smtp_password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('smtp_password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.smtp_password_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="smtp_port">{{ trans('cruds.user.fields.smtp_port') }}</label>
                <input class="form-control {{ $errors->has('smtp_port') ? 'is-invalid' : '' }}" type="text" name="smtp_port" id="smtp_port" value="{{ old('smtp_port', '') }}">
                @if($errors->has('smtp_port'))
                    <div class="invalid-feedback">
                        {{ $errors->first('smtp_port') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.smtp_port_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="smtp_additional_flag">{{ trans('cruds.user.fields.smtp_additional_flag') }}</label>
                <input class="form-control {{ $errors->has('smtp_additional_flag') ? 'is-invalid' : '' }}" type="text" name="smtp_additional_flag" id="smtp_additional_flag" value="{{ old('smtp_additional_flag', '') }}">
                @if($errors->has('smtp_additional_flag'))
                    <div class="invalid-feedback">
                        {{ $errors->first('smtp_additional_flag') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.smtp_additional_flag_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="last_postmaster_run">{{ trans('cruds.user.fields.last_postmaster_run') }}</label>
                <input class="form-control {{ $errors->has('last_postmaster_run') ? 'is-invalid' : '' }}" type="text" name="last_postmaster_run" id="last_postmaster_run" value="{{ old('last_postmaster_run', '') }}">
                @if($errors->has('last_postmaster_run'))
                    <div class="invalid-feedback">
                        {{ $errors->first('last_postmaster_run') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.last_postmaster_run_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="media_path_slug">{{ trans('cruds.user.fields.media_path_slug') }}</label>
                <input class="form-control {{ $errors->has('media_path_slug') ? 'is-invalid' : '' }}" type="text" name="media_path_slug" id="media_path_slug" value="{{ old('media_path_slug', '') }}">
                @if($errors->has('media_path_slug'))
                    <div class="invalid-feedback">
                        {{ $errors->first('media_path_slug') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.media_path_slug_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="marketing_username">{{ trans('cruds.user.fields.marketing_username') }}</label>
                <input class="form-control {{ $errors->has('marketing_username') ? 'is-invalid' : '' }}" type="text" name="marketing_username" id="marketing_username" value="{{ old('marketing_username', '') }}">
                @if($errors->has('marketing_username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('marketing_username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.marketing_username_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="marketing_password">{{ trans('cruds.user.fields.marketing_password') }}</label>
                <input class="form-control {{ $errors->has('marketing_password') ? 'is-invalid' : '' }}" type="password" name="marketing_password" id="marketing_password">
                @if($errors->has('marketing_password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('marketing_password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.marketing_password_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="marketing_type">{{ trans('cruds.user.fields.marketing_type') }}</label>
                <input class="form-control {{ $errors->has('marketing_type') ? 'is-invalid' : '' }}" type="text" name="marketing_type" id="marketing_type" value="{{ old('marketing_type', '') }}">
                @if($errors->has('marketing_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('marketing_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.marketing_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sp_username">{{ trans('cruds.user.fields.sp_username') }}</label>
                <input class="form-control {{ $errors->has('sp_username') ? 'is-invalid' : '' }}" type="text" name="sp_username" id="sp_username" value="{{ old('sp_username', '') }}">
                @if($errors->has('sp_username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sp_username') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.sp_username_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sp_password">{{ trans('cruds.user.fields.sp_password') }}</label>
                <input class="form-control {{ $errors->has('sp_password') ? 'is-invalid' : '' }}" type="password" name="sp_password" id="sp_password">
                @if($errors->has('sp_password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sp_password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.sp_password_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_of_join">{{ trans('cruds.user.fields.date_of_join') }}</label>
                <input class="form-control date {{ $errors->has('date_of_join') ? 'is-invalid' : '' }}" type="text" name="date_of_join" id="date_of_join" value="{{ old('date_of_join') }}">
                @if($errors->has('date_of_join'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_of_join') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.date_of_join_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_of_insurance">{{ trans('cruds.user.fields.date_of_insurance') }}</label>
                <input class="form-control date {{ $errors->has('date_of_insurance') ? 'is-invalid' : '' }}" type="text" name="date_of_insurance" id="date_of_insurance" value="{{ old('date_of_insurance') }}">
                @if($errors->has('date_of_insurance'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_of_insurance') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.date_of_insurance_helper') }}</span>
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