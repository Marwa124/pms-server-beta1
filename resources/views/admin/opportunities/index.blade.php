@extends('layouts.admin')
@section('content')
@can('opportunity_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.opportunities.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.opportunity.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.opportunity.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Opportunity">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.opportunity.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.opportunity.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.opportunity.fields.probability') }}
                        </th>
                        <th>
                            {{ trans('cruds.opportunity.fields.stages') }}
                        </th>
                        <th>
                            {{ trans('cruds.opportunity.fields.closed_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.opportunity.fields.next_action') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($opportunities as $key => $opportunity)
                        <tr data-entry-id="{{ $opportunity->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $opportunity->id ?? '' }}
                            </td>
                            <td>
                                {{ $opportunity->name ?? '' }}
                            </td>
                            <td>
                                {{ $opportunity->probability ?? '' }}
                            </td>
                            <td>
                                {{ $opportunity->stages ?? '' }}
                            </td>
                            <td>
                                {{ $opportunity->closed_date ?? '' }}
                            </td>
                            <td>
                                {{ $opportunity->next_action ?? '' }}
                            </td>
                            <td>
                                @can('opportunity_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.opportunities.show', $opportunity->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('opportunity_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.opportunities.edit', $opportunity->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('opportunity_delete')
                                    <form action="{{ route('admin.opportunities.destroy', $opportunity->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('opportunity_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.opportunities.massDestroy') }}",
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
  let table = $('.datatable-Opportunity:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  $('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value
      table
        .column($(this).parent().index())
        .search(value, strict)
        .draw()
  });
})

</script>
@endsection