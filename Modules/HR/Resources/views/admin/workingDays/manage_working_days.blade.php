@extends('layouts.admin')
@section('title', __('Leave Categories'))

@section('main_content')
<div class="content-wrapper">

  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">{{ __('Manage working days') }}</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
          <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        </div>
      </div>
      <form action="{{ route('working-days.update')}}" method="post">
        {{ csrf_field() }}
        <div class="box-body">
          <!-- Notification Box -->
          <div class="col-md-12">
            @if (!empty(Session::get('message')))
            <div class="alert alert-success alert-dismissible" id="notification_box">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <i class="icon fa fa-check"></i> {{ Session::get('message') }}
            </div>
            @elseif (!empty(Session::get('exception')))
            <div class="alert alert-warning alert-dismissible" id="notification_box">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <i class="icon fa fa-warning"></i> {{ Session::get('exception') }}
            </div>
            @endif
          </div>
          <!-- /.Notification Box -->
          <div class="col-md-12">
            <div class="form-group">
              @foreach($working_days as $working_day)
              <label class="checkbox-inline">
                @if($working_day['working_status'] == 1)
                <input type="hidden" name="day[]" value="1"><input checked type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value">
                @else
                <input type="hidden" name="day[]" value="0"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value">
                @endif
                <span>{{ $working_day['day'] }}</span>
              </label>
              @endforeach
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary btn-flat"><i class="icon fa fa-edit"></i> {{ __('Update') }}</button>
        </div>
      </form>
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
</div>
@endsection
