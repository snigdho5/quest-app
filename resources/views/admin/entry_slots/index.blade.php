@extends('admin.layout.master')
@section('content')


<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Entry Slots
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Entry Slots</li>
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
  

    @if(in_array('add',$access_type))
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title" style="display:block">New Entry Slot</h3>
      </div>
      <div class="box-body">
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          @if($errors->any()) <p class="text-danger">{{ $errors->first() }}</p> @endif
          {{ csrf_field() }}
          <div class="row">
            <div class="col-sm-3">
              <div class="input-group">
                <div class="input-group-addon">From</div>
                <input type="text" class="form-control" name="slot_start" required value="{{ old('slot_start') }}">
              </div>
            </div>
            <div class="col-sm-3">
              <div class="input-group">
                <div class="input-group-addon">To</div>
                <input type="text" class="form-control" name="slot_end" required value="{{ old('slot_end') }}">
              </div>
            </div>
            <div class="col-sm-3">
              <select class="form-control" name="active" required>
                <option value="" selected disabled>-- Select Status --</option>
                <option value="1" {{old('active')=='1'?'selected':''}}>Active</option>
                <option value="0" {{old('active')=='0'?'selected':''}}>Inactive</option>
              </select>
            </div>
            <div class="col-sm-3"><button type="submit" class="btn btn-success btn-block">Add Slot</button></div>
          </div>
        </form>
      </div>
    </div>
    @endif

    <div class="box">
      <div class="box-header">
        <h3 class="box-title" style="display:block">Slot List</h3>
      </div>
      <div class="box-body">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>From</th>
              <th>To</th>
              <th>Active</th>
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $value)
            <tr>
              <td>{{ date('h:i a',strtotime($value->slot_start)) }}</td>
              <td>{{ date('h:i a',strtotime($value->slot_end)) }}</td>
              <td>{{ $value->active=='0'?'No':'Yes' }}
                @if(in_array('status',$access_type))
                <a href="admin/entry_slots/status/{{ $value->id }}/{{ $value->active=='0'?'1':'0' }}"><i class="fa fa-refresh fa-fw"></i></a>
                @endif
              </td>
              <td class="text-right">
                @if(in_array('delete',$access_type))
                <a title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Once deleted it cannot be restored. Are you sure you want to delete this?')" href="admin/entry_slots/delete/{{ $value->id }}"><i class="fa fa-close fa-fw"></i></a>
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
    $('#listtable').DataTable()

    $('[name="slot_start"],[name="slot_end"]').datetimepicker({format: 'hh:mm a'});
  });
</script>



@endsection