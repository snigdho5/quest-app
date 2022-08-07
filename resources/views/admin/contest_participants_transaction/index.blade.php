@extends('admin.layout.master')
@section('content')


<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="bower_components/datatables.net/js/Buttons-1.4.2/css/buttons.bootstrap.min.css"/>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Contest Participants Transaction
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Contest Participants Transaction</li>
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
        <h3 class="box-title" style="display:block">Contest Participants Transaction List</h3>
      </div>
      <div class="box-body">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>User</th>
              <th>Contest</th>
              <th>Dine</th>
              <th>Threshold</th>
              <th>Unique Code</th>
              <th>Transaction Amount</th>
              <th>Transaction Date</th>
              {{-- <th>Active</th> --}}
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $value)
            <tr>
              <td> {{ get_anydata('user',$value->participantDetails->user_id,'name') }}</td>
              <td> {{ get_anydata('contest',$value->participantDetails->contest_id,'name') }}</td>
              <td> {{ $value->dineDetails->name }}</td>
              <td> {{ $value->thresholdDetails->percentage }}%</td>
              <td> {{ $value->unique_code }}</td>
              <td> {{ $value->trans_amount }}</td>
              
              <td>{{ $value->trans_date}}</td>
              {{-- <td>{{ $value->status=='0'?'No':'Yes' }} <a href="admin/contest_participants_transaction/status/{{ $value->id }}/{{ $value->status=='0'?'1':'0' }}"><i class="fa fa-refresh fa-fw"></i></a></td> --}}
              <td class="text-right">
                @if(in_array('edit',$access_type))
                <a title="View" class="btn btn-success btn-xs" href="admin/contest_participants_transaction/view/{{ $value->id }}"><i class="fa fa-eye fa-fw"></i></a>
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
<script src="bower_components/datatables.net/js/JSZip-2.5.0/jszip.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="bower_components/datatables.net/js/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>
<script src="bower_components/datatables.net/js/Buttons-1.4.2/js/buttons.bootstrap.min.js"></script>
<script src="bower_components/datatables.net/js/Buttons-1.4.2/js/buttons.html5.min.js"></script>
<script>
  $(document).ready(function() {
    $('#listtable').DataTable({
      dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
        {
          'filename':'Contest_Participants_Transaction_List_{{date('Y-m-d')}}',
          'extend':'excelHtml5',
          'exportOptions':{
            'columns':':not(:last-child)'
          },
          'text':'<i class="fa fa-download fa-fw"></i> Download'
        },
        {
          'filename':'Contest_Participants_Transaction_List_{{date('Y-m-d')}}',
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