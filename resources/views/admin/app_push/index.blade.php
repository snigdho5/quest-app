@extends('admin.layout.master')
@section('content')


<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Push Notification
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Push Notification</li>
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
        <h3 class="box-title" style="display:block">Notification List</strong>
        @if(in_array('add',$access_type))
        <a class="btn btn-primary btn-sm pull-right" href="admin/app_push/create/">New Notification</a></h3>
        @endif
      </div>
      <div class="box-body">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Title</th>
              <th>Body</th>
              <th>Type</th>
              <th>Created</th>
              <th>Modified</th>
              <th>Status</th>
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $value)
            <tr>
              <td>{{ $value->title }}</td>
              <td title="{{ $value->body }}">{{ str_limit($value->body,50) }}</td>
              <td>{{ ucfirst($value->type) }}</td>
              <td>{{ $value->created_at->format('M d, Y - h:i a') }}</td>
              <td>{{ $value->updated_at->format('M d, Y - h:i a') }}</td>
              <td>{{ $value->push=='0'?'Draft':'Sent' }}<br>
                @if(in_array('trigger',$access_type))
                  @if($value->push=='0')
                  <a title="Sent" class="btn btn-success btn-xs" href="admin/app_push/trigger/{{ $value->id }}"><i class="fa fa-paper-plane-o fa-fw"></i> Sent Now</a>
                  @endif
                @endif
                @if($value->push == 1)
                <small>{{ $value->push_time->format('M d, Y - h:i a') }}</small>
                @endif
              </td>
              <td class="text-right">
                @if(in_array('edit',$access_type))
                  @if($value->push=='0')
                  <a title="Edit" class="btn btn-success btn-xs" href="admin/app_push/edit/{{ $value->id }}"><i class="fa fa-pencil fa-fw"></i></a>
                  @endif
                @endif

                @if(in_array('delete',$access_type))
                  @if($value->push=='0')
                  <a title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Once deleted it cannot be restored. Are you sure you want to delete this?')" href="admin/app_push/delete/{{ $value->id }}"><i class="fa fa-close fa-fw"></i></a>
                  @endif
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
  });
</script>



@endsection