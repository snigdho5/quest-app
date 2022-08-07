@extends('admin.layout.master')
@section('content')


<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="bower_components/datatables.net/js/Buttons-1.4.2/css/buttons.bootstrap.min.css"/>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Store/Dine Review
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Store/Dine Review</li>
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
        <h3 class="box-title" style="display:block">Review List</h3>
      </div>
      <div class="box-body">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Created</th>
              <th>User</th>
              <th>Store/Dine</th>
              <th>Rating</th>
              <th>Message</th>
              <th>Approve</th>
              
              {{-- <th>Active</th> --}}
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $value)
            <tr>
              <td>{{ $value->created_at->format('M d, Y - h:i a') }}</td>
              <td> {{ get_anydata('user',$value->user_id,'name') }}</td>
              <td> {{ get_anydata('store',$value->store_id,'name') }}</td>
              <td>{{$value->rate}}</td>
              <td> {{ ($value->message!='')?str_limit(strip_tags($value->message),70):'--' }}</td>
              
              <td>{{ $value->approve=='0'?'No':'Yes' }} <a href="admin/store_review/status/{{ $value->id }}/{{ $value->approve=='0'?'1':'0' }}"><i class="fa fa-refresh fa-fw"></i></a></td>

              <td class="text-right">
                @if(in_array('edit',$access_type))
                <a title="View" class="btn btn-success btn-xs" href="admin/store_review/view/{{ $value->id }}"><i class="fa fa-eye fa-fw"></i></a>
                @endif

               {{--  @if(in_array('delete',$access_type))
                <a title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Once deleted it cannot be restored. Are you sure you ant to delete this?')" href="admin/store_rating/delete/{{ $value->id }}"><i class="fa fa-close fa-fw"></i></a>
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
<script src="bower_components/datatables.net/js/JSZip-2.5.0/jszip.min.js"></script>

<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="bower_components/datatables.net/js/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>
<script src="bower_components/datatables.net/js/Buttons-1.4.2/js/buttons.bootstrap.min.js"></script>
<script src="bower_components/datatables.net/js/Buttons-1.4.2/js/buttons.html5.min.js"></script>
<script>
  $(document).ready(function() {
    $('#listtable').DataTable({
      order: [[ 0, "desc" ]],
      dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
        {
          'filename':'Review_Transaction_List_{{date('Y-m-d')}}',
          'extend':'excelHtml5',
          'exportOptions':{
            'columns':':not(:last-child)'
          },
          'text':'<i class="fa fa-download fa-fw"></i> Download'
        },
        {
          'filename':'Review_Transaction_List_{{date('Y-m-d')}}',
          'extend':'excelHtml5',
          'exportOptions':{
            'columns':':not(:last-child)',
            'modifier': {
              'search': 'none',
              'order': 'applied'
            }
          },
          'text':'<i class="fa fa-download fa-fw"></i> Download All'
        },
      ]
    })
  });
</script>



@endsection