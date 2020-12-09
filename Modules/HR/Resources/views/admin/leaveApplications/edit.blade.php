@extends('layouts.admin')
@section('content')

@inject('leaveAppModel', 'Modules\HR\Entities\LeaveApplication')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.leaveApplication.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("hr.admin.leave-applications.update", [$leaveApplication->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.leaveApplication.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $leaveApplication->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leaveApplication.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="leave_category_id">{{ trans('cruds.leaveApplication.fields.leave_category') }}</label>
                <select class="form-control select2 {{ $errors->has('leave_category') ? 'is-invalid' : '' }}" name="leave_category_id" id="leave_category_id" required>
                    @foreach($leave_categories as $id => $leave_category)
                        <option value="{{ $id }}" {{ (old('leave_category_id') ? old('leave_category_id') : $leaveApplication->leave_category->id ?? '') == $id ? 'selected' : '' }}>{{ $leave_category }}</option>
                    @endforeach
                </select>
                @if($errors->has('leave_category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('leave_category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leaveApplication.fields.leave_category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reason">{{ trans('cruds.leaveApplication.fields.reason') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('reason') ? 'is-invalid' : '' }}" name="reason" id="reason">{!! old('reason', $leaveApplication->reason) !!}</textarea>
                @if($errors->has('reason'))
                    <div class="invalid-feedback">
                        {{ $errors->first('reason') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leaveApplication.fields.reason_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.leaveApplication.fields.leave_type') }}</label>
                <select class="form-control {{ $errors->has('leave_type') ? 'is-invalid' : '' }}" name="leave_type" id="leave_type" required>
                    <option value disabled {{ old('leave_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach($leaveAppModel::LEAVE_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('leave_type', $leaveApplication->leave_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('leave_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('leave_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leaveApplication.fields.leave_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="hours">{{ trans('cruds.leaveApplication.fields.hours') }}</label>
                <input class="form-control {{ $errors->has('hours') ? 'is-invalid' : '' }}" type="text" name="hours" id="hours" value="{{ old('hours', $leaveApplication->hours) }}">
                @if($errors->has('hours'))
                    <div class="invalid-feedback">
                        {{ $errors->first('hours') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leaveApplication.fields.hours_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="leave_start_date">{{ trans('cruds.leaveApplication.fields.leave_start_date') }}</label>
                <input class="form-control date {{ $errors->has('leave_start_date') ? 'is-invalid' : '' }}" type="text" name="leave_start_date" id="leave_start_date" value="{{ old('leave_start_date', $leaveApplication->leave_start_date) }}" required>
                @if($errors->has('leave_start_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('leave_start_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leaveApplication.fields.leave_start_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="leave_end_date">{{ trans('cruds.leaveApplication.fields.leave_end_date') }}</label>
                <input class="form-control date {{ $errors->has('leave_end_date') ? 'is-invalid' : '' }}" type="text" name="leave_end_date" id="leave_end_date" value="{{ old('leave_end_date', $leaveApplication->leave_end_date) }}">
                @if($errors->has('leave_end_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('leave_end_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leaveApplication.fields.leave_end_date_helper') }}</span>
            </div>

            <?php 
                $notifyUsers = globalNotificationId($leaveApplication->user->id);
                $admins = in_array(auth()->user()->id, $notifyUsers);
            ?>

            {{-- @if (auth()->user()->id != $leaveApplication->user_id) --}}
            @if ($admins)
                    <div class="form-group">
                        <label>{{ trans('cruds.leaveApplication.fields.application_status') }}</label>
                        <select class="form-control {{ $errors->has('application_status') ? 'is-invalid' : '' }}" name="application_status" id="application_status">
                            <option value disabled {{ old('application_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach($leaveAppModel::APPLICATION_STATUS_SELECT as $key => $label)
                                <option value="{{ $key }}" {{ old('application_status', $leaveApplication->application_status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('application_status'))
                            <div class="invalid-feedback">
                                {{ $errors->first('application_status') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.leaveApplication.fields.application_status_helper') }}</span>
                    </div>
            @endif
            <div class="form-group">
                <label for="attachments">{{ trans('cruds.leaveApplication.fields.attachments') }}</label>
                <div class="needsclick dropzone {{ $errors->has('attachments') ? 'is-invalid' : '' }}" id="attachments-dropzone">
                </div>
                @if($errors->has('attachments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('attachments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leaveApplication.fields.attachments_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comments">{{ trans('cruds.leaveApplication.fields.comments') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('comments') ? 'is-invalid' : '' }}" name="comments" id="comments">{!! old('comments', $leaveApplication->comments) !!}</textarea>
                @if($errors->has('comments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.leaveApplication.fields.comments_helper') }}</span>
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

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/admin/leave-applications/ckmedia', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', {{ $leaveApplication->id ?? 0 }});
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

<script>
    Dropzone.options.attachmentsDropzone = {
    url: '{{ route('hr.admin.leave-applications.storeMedia') }}',
    maxFilesize: 2, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2
    },
    success: function (file, response) {
      $('form').find('input[name="attachments"]').remove()
      $('form').append('<input type="hidden" name="attachments" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="attachments"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($leaveApplication) && $leaveApplication->attachments)
      var file = {!! json_encode($leaveApplication->attachments) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="attachments" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection
