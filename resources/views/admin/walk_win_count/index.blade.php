@extends('admin.layout.master')
@section('content')


<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Walk n Win Count
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Walk n Win Count</li>
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
        <h3 class="box-title" style="display:block">List</h3>
          <hr>
            <form class="row" action="" method="post" enctype="multipart/form-data">
              {{ csrf_field()}}
                <div class="col-sm-4">
                  <div class="input-group"><span class="input-group-addon">Start Date</span><input type="text" name="start_date" class="form-control" value="{{request('start_date')}}" placeholder="Enter Start Date" required></div>
                </div>
                <div class="col-sm-4">
                  <div class="input-group"><span class="input-group-addon">End Date</span><input type="text" name="end_date" class="form-control" value="{{request('end_date')}}" placeholder="Enter End Date" required></div>
                </div>
                <div class="col-sm-4">
                  <button class="btn btn-block btn-warning">Filter</button>
                </div>
            </form>
        <hr>
      </div>
      <div class="box-body">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Contact</th>
              <th>Email</th>
              <th>Walk n Win Count</th>
              {{-- <th>Created</th> --}}
              
            </tr>
          </thead>
          <tbody>
            @foreach($alldata as $value)
              @if($value['total_steps'] > 0)
              <tr>
                <td> {{ $value['name'] }}</td>
                <td> {{ $value['phone'] }}</td>
                <td> {{ $value['email'] }}</td>
                <td> {{ $value['total_steps'] }}</td>
                {{-- <td>{{ $value->created_at->format('M d, Y - h:i a') }}</td> --}}
              </tr>
              @endif
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
    $('[name="start_date"]').datetimepicker({format: 'YYYY-MM-DD'});
    $('[name="end_date"]').datetimepicker({format: 'YYYY-MM-DD'});
    $('#listtable').DataTable({
      order:['3','desc']
    })
  });
</script>



@endsection