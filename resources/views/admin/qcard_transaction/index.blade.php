@extends('admin.layout.master')
@section('content')


<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Qcard Transaction
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Qcard Transaction</li>
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
        <h3 class="box-title" style="display:block">Qcard Transaction List</h3>
      </div>
      <div class="box-body">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>User Name</th>
              <th>Type</th>
              <th>Amount</th>
              <th>Created</th>
              {{-- <th>Active</th> --}}
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $value)
            <tr>
              <td> {{ get_anydata('user',$value->user_id,'name') }}</td>
              <td> {{ $value->type }}</td>
              <td> {{ $value->amount }}</td>
              <td>{{ $value->created_at->format('M d, Y - h:i a') }}</td>
              {{-- <td>{{ $value->status=='0'?'No':'Yes' }} <a href="admin/qcard_transaction/status/{{ $value->id }}/{{ $value->status=='0'?'1':'0' }}"><i class="fa fa-refresh fa-fw"></i></a></td> --}}
              <td class="text-right">
                @if(in_array('edit',$access_type))
                <a title="View" class="btn btn-success btn-xs" href="admin/qcard_transaction/view/{{ $value->id }}"><i class="fa fa-eye fa-fw"></i></a>
                @endif

                {{-- @if(in_array('delete',$access_type))
                <a title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Once deleted it cannot be restored. Are you sure you ant to delete this?')" href="admin/qcard_transaction/delete/{{ $value->id }}"><i class="fa fa-close fa-fw"></i></a>
                @endif --}}
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