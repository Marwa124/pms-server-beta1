@can('employee_award_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.employee-awards.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.employeeAward.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.employeeAward.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-userEmployeeAwards">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.employeeAward.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeAward.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeAward.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeAward.fields.gift_item') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeAward.fields.award_amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeAward.fields.view_status') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeAward.fields.given_date') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employeeAwards as $key => $employeeAward)
                        <tr data-entry-id="{{ $employeeAward->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $employeeAward->id ?? '' }}
                            </td>
                            <td>
                                {{ $employeeAward->name ?? '' }}
                            </td>
                            <td>
                                {{ $employeeAward->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $employeeAward->gift_item ?? '' }}
                            </td>
                            <td>
                                {{ $employeeAward->award_amount ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\EmployeeAward::VIEW_STATUS_RADIO[$employeeAward->view_status] ?? '' }}
                            </td>
                            <td>
                                {{ $employeeAward->given_date ?? '' }}
                            </td>
                            <td>
                                @can('employee_award_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.employee-awards.show', $employeeAward->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('employee_award_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.employee-awards.edit', $employeeAward->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('employee_award_delete')
                                    <form action="{{ route('admin.employee-awards.destroy', $employeeAward->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('employee_award_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employee-awards.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-userEmployeeAwards:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection