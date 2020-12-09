@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.vacation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("hr.admin.vacations.update", [$vacation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
              <label class="required" for="user_id">{{ trans('cruds.vacation.fields.user') }}</label>
              <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                  @foreach($users as $id => $user)
                      <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $vacation->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                  @endforeach
              </select>
              @if($errors->has('user'))
                  <div class="invalid-feedback">
                      {{ $errors->first('user') }}
                  </div>
              @endif
              <span class="help-block">{{ trans('cruds.vacation.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="start_date">{{ trans('cruds.vacation.fields.start_date') }}</label>
                <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date', $vacation->start_date) }}" required>
                @if($errors->has('start_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vacation.fields.start_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="end_date">{{ trans('cruds.vacation.fields.end_date') }}</label>
                <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}" type="text" name="end_date" id="end_date" value="{{ old('end_date', $vacation->end_date) }}" required>
                @if($errors->has('end_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('end_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.vacation.fields.end_date_helper') }}</span>
            </div>
            <div class="form-group">
              <label for="description">{{ trans('cruds.vacation.fields.description') }}</label>
              <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $vacation->description) !!}</textarea>
              @if($errors->has('description'))
                  <div class="invalid-feedback">
                      {{ $errors->first('description') }}
                  </div>
              @endif
              <span class="help-block">{{ trans('cruds.vacation.fields.description_helper') }}</span>
            </div>
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
                xhr.open('POST', '/admin/vacations/ckmedia', true);
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
                data.append('crud_id', {{ $vacation->id ?? 0 }});
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
  url: '{{ route('hr.admin.vacations.storeMedia') }}',
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
@if(isset($vacation) && $vacation->attachments)
    var file = {!! json_encode($vacation->attachments) !!}
        this.options.addedfile.call(this, file)
	// this.options.thumbnail.call(this, file);
	// this.emit("complete", file);

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