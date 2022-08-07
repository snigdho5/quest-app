@extends('admin.layout.master')
@section('content')


<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Footer Navigation
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Footer Navigation</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    @if(session('success'))
      <p class="alert alert-success"><i class="fa fa-fw fa-check"></i>{{ session('success') }}</p>
    @endif
    @if(session('error'))
      <p class="alert alert-danger"><i class="fa fa-fw fa-warning"></i>{{ session('error') }}</p>
    @endif

    <div class="box">
      <div class="box-header">
        <h3 class="box-title" style="display:block">Navigation List
          @if(in_array('add',$access_type))
          <a class="btn btn-primary btn-sm pull-right" href="admin/footer_navigation/create/">Add New</a></h3>
          @endif
      </div>
      <div class="box-body">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Order</th>
              <th>Menu</th>
              <th>Parent</th>
              <th>Link</th>
              <th>Created</th>
              <th>Modified</th>
              <th>Active</th>
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $value)
            <tr>
              <td>
                @if(in_array('order',$access_type))
                <form action="" method="post">
                  {{ csrf_field() }}
                  <input type="hidden" name="id" value="{{ $value->id }}">
                  <select name="o" onchange="this.form.submit()">
                    @for ($i=1; $i <= $data->where('parent_id',$value->parent_id)->count(); $i++)
                    <option value="{{ $i }}" {{ $value->priority==$i?'selected':'' }}>{{ $i }}</option>
                    @endfor
                  </select>
                </form>
                <span class="hidden">{{ $value->priority }}</span>
                @else
                {{ $value->priority }}
                @endif
              </td>
              <td>{{ $value->menu }}</td>
              <td>{{ $value->parent ? $value->parent->menu : '' }}</td>
              <td>{{ $value->link }}</td>
              <td>{{ $value->created_at->format('M d, Y - h:i a') }}</td>
              <td>{{ $value->updated_at->format('M d, Y - h:i a') }}</td>
              <td>{{ $value->active=='0'?'No':'Yes' }}
                @if(in_array('status',$access_type))
                <a href="admin/footer_navigation/status/{{ $value->id }}/{{ $value->active=='0'?'1':'0' }}"><i class="fa fa-refresh fa-fw"></i></a>
                @endif
              </td>
              <td class="text-right">
                @if(in_array('edit',$access_type))
                <a title="Edit" class="btn btn-success btn-xs" href="admin/footer_navigation/edit/{{ $value->id }}"><i class="fa fa-pencil fa-fw"></i></a>
                @endif
                @if(in_array('delete',$access_type))
                <a title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Once deleted it cannot be restored. Are you sure you want to delete this?')" href="admin/footer_navigation/delete/{{ $value->id }}"><i class="fa fa-close fa-fw"></i></a>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(document).ready(function() {
    $('#listtable').dataTable({
            "orderFixed": [2, 'asc'],
            "lengthMenu": [[-1,25, 50, 100], ["All", 25, 50, 100]],
            "drawCallback": function ( settings ) {
                  var api = this.api();
                  var rows = api.rows( {page:'current'} ).nodes();
                  var last=null;
                  api.column(2, {page:'current'} ).data().each( function ( group, i ) {
                      if ( last !== group ) {
                          $(rows).eq( i ).before(
                              '<tr class="group bg-olive"><td colspan="8">'+(group==''?'Main Menu':'Sub Menu of <b>'+group+'</b>')+'</td></tr>'
                          );
                          last = group;
                      }
                  } );
            }
        })
  });

</script>


@endsection