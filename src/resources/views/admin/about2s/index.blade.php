@extends('layouts.admin')
@section('content')
@can('about2_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.about2s.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.about2.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.about2.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-about2">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.about2.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.about2.fields.no') }}
                        </th>
                        <th>
                            {{ trans('cruds.about2.fields.title_1') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.about2.fields.title_2') }}
                        </th> --}}
                        <th>
                            {{ trans('cruds.about2.fields.title_row') }}
                        </th>
                        {{-- <th>
                            {{ trans('cruds.about2.fields.image') }}
                        </th> --}}
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($about2s as $key => $a)
                        <tr data-entry-id="{{ $a->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $loop->iteration ?? '' }}
                            </td>
                            <td>
                                {{ $a->no ?? '' }}
                            </td>
                            <td>
                                {{ $a->title_1 ?? '' }}
                            </td>
                            {{-- <td>
                                {{ $a->title_2 ?? '' }}
                            </td> --}}
                            <td>
                                {{ $a->title_row ?? '' }}
                            </td>
                            {{-- <td>
                                @if($a->image)
                                    <a href="{{ $a->image->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $a->image->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td> --}}
                            <td>
                                @can('about2_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.about2s.show', $a->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('about2_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.about2s.edit', $a->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('about2_delete')
                                    <form action="{{ route('admin.about2s.destroy', $a->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('about2_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.about2s.massDestroy') }}",
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
    pageLength: 100,
  });
  let table = $('.datatable-about2:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection