@extends('admin.layout.master')
@section('content')

<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Admin Type
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Admin Type</li>
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
        <h3 class="box-title" style="display:block">Type List <a class="btn btn-primary btn-sm pull-right" href="admin/admin_type/create/">Add New</a></h3>
      </div>
      <div class="box-body">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Type</th>
              <th>Active</th>
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $value)
            <tr>
              <td>{{ $value->title }}</td>
              <td>{{ $value->active == '0'?'No':'Yes' }} <a href="admin/admin_type/status/{{ $value->id }}/{{ $value->active =='0'?'1':'0' }}"><i class="fa fa-refresh fa-fw"></i></a></td>
              <td class="text-right">
                <a title="Edit" class="btn btn-success btn-xs" href="admin/admin_type/edit/{{ $value->id }}"><i class="fa fa-pencil fa-fw"></i></a>
                <a title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Once deleted it cannot be restored. Are you sure you want to delete this?')" href="admin/admin_type/delete/{{ $value->id }}"><i class="fa fa-close fa-fw"></i></a>
              </td>
            </tr>
            <?php endforeach?>
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