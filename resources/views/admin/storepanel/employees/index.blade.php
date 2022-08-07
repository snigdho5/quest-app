@extends('admin.storepanel.master')
@section('content')


<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    @if(session('success'))
      <p class="alert alert-success"><i class="fa fa-fw fa-check"></i>{{ session('success') }}</p>
    @endif
    @if(session('error'))
      <p class="alert alert-danger"><i class="fa fa-fw fa-warning"></i>{{ session('error') }}</p>
    @endif

    <div class="box">
      <div class="box-header">
        <h3 class="box-title" style="display:block">Employee List</strong>
        <a class="btn btn-primary btn-sm pull-right" href="admin/store-panel/employees/create/">Add New</a></h3>
      </div>
      <div class="box-body">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Phone</th>
              <th>Created</th>
              <th>Modified</th>
              <th>Active</th>
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
        <?php echo Session::get('store_id'); ?>
            @foreach($data as $value)
            <tr>
              <td>{{ $value->name }}</td>
              <td>{{ $value->phone }}</td>
              <td>{{ $value->created_at->format('M d, Y - h:i a') }}</td>
              <td>{{ $value->updated_at->format('M d, Y - h:i a') }}</td>
              <td>{{ $value->active=='0'?'No':'Yes' }}
                <a href="admin/store-panel/employees/status/{{ $value->id }}/{{ $value->active=='0'?'1':'0' }}"><i class="fa fa-refresh fa-fw"></i></a>
              </td>
              <td class="text-right">
                <a title="Edit" class="btn btn-success btn-xs" href="admin/store-panel/employees/edit/{{ $value->id }}"><i class="fa fa-pencil fa-fw"></i></a>

                <a title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Once deleted it cannot be restored. Are you sure you want to delete this?')" href="admin/store-panel/employees/delete/{{ $value->id }}"><i class="fa fa-close fa-fw"></i></a>
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
    $('#listtable').DataTable()
  });
</script>



@endsection