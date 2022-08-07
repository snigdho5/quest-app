@extends('admin.layout.master')
@section('content')


<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Entry Booking
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Entry Booking</li>
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
        <h3 class="box-title" style="display:block">Booking List</h3>
      </div>
      <div class="box-body">
      	<form action="">
          <div class="row"> 
            <div class="col-sm-11">
              <div class="row">
                <div class="col-sm-3">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option {{ request()->status=='All'?'selected':'' }}>All</option>
                    <option {{ request()->status=='Booked'?'selected':'' }}>Booked</option>
                    <option {{ request()->status=='No Show'?'selected':'' }}>No Show</option>
                    <option {{ request()->status=='Cancelled'?'selected':'' }}>Cancelled</option>
                    <option {{ request()->status=='Entry Logged'?'selected':'' }}>Entry Logged</option>
                    <option {{ request()->status=='Exit Logged'?'selected':'' }}>Exit Logged</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label>No. of Visitors</label>
                  <select name="others" class="form-control">
                    <option {{ request()->others=='Any'?'selected':'' }}>Any</option>
                    <option {{ request()->others=='1'?'selected':'' }}>1</option>
                    <option {{ request()->others=='2'?'selected':'' }}>2</option>
                    <option {{ request()->others=='3'?'selected':'' }}>3</option>
                    <option {{ request()->others=='4'?'selected':'' }}>4</option>
                    <option {{ request()->others=='5'?'selected':'' }}>5</option>
                    <option {{ request()->others=='6'?'selected':'' }}>6</option>
                  </select>
                </div>
                
                <div class="col-sm-4">
                  <label>Date Range</label>
                  <div class="input-daterange input-group" id="datepicker">
                      <input type="text" class="form-control" name="sdate" autocomplete="off" placeholder="Select Date"  value="{{ request()->sdate }}" />
                      <span class="input-group-addon">to</span>
                      <input type="text" class="form-control" name="edate" autocomplete="off"  placeholder="Select Date" value="{{ request()->edate }}" />
                  </div>
                </div>
                <div class="col-sm-3">
                  <label>Slot</label>
                  <select name="slot" class="form-control">
                    <option {{ request()->slot=='All'?'selected':'' }}>All</option>
                    @foreach ($slots as $slot)
                    @php $val= date('h:i a',strtotime($slot->slot_start)) .' - '. date('h:i a',strtotime($slot->slot_end)); @endphp
                    <option {{ request()->slot==$val?'selected':'' }}>{{$val}}</option>
                    @endforeach
                    
                  </select>
                </div>
                
              </div>
            </div>
            <div class="col-sm-1">
              <label style="opacity: 0">-</label>
              <button class="btn btn-success btn-block">Filter</button>
            </div>
          </div>
        </form>
        <hr>
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Date</th>
              <th>Slot</th>
              <th>With</th>
              <th>Status</th>
              <th>Booked At</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $value)
            @if((request()->status == "Booked" AND strtotime($value->date." ".$value->slot_end)>time()) OR (request()->status == "No Show" AND strtotime($value->date." ".$value->slot_end)<=time()) OR (request()->status != "Booked" AND request()->status != "No Show"))
            <tr>
              <td>{{ $value->user->name }}</td>
              <td>{{ $value->user->email }}</td>
              <td>{{ $value->date }}</td>
              <td>{{ $value->slot }}</td>
              <td>{{ $value->child }} other{{ $value->child>1?'s':'' }}</td>
              <td>{{ $value->status==1?(strtotime($value->date." ".$value->slot_end)>time()?'Booked':'No Show'):'' }} {{ $value->status==0?'Cancelled':'' }} {{ $value->status==2?'Entry Logged':'' }} {{ $value->status==-1?'Exit Logged':'' }}</td>
              <td>{{ $value->created_at->format('M d, Y - h:i a') }}</td>
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


<script src="bower_components/datatables.net/js/JSZip-2.5.0/jszip.min.js"></script>
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="bower_components/datatables.net/js/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>
<script src="bower_components/datatables.net/js/Buttons-1.4.2/js/buttons.bootstrap.min.js"></script>
<script src="bower_components/datatables.net/js/Buttons-1.4.2/js/buttons.html5.min.js"></script>

<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
  $(document).ready(function() {
    $('#listtable').DataTable({
      dom: "<'row'<'col-sm-6'l><'col-sm-4'f><'col-sm-2 text-right'B>>" + "<'row'<'col-sm-12'i><'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
        {
          'filename':'Pre_booking_List_{{date('Y-m-d')}}',
          'extend':'excelHtml5',
          'exportOptions':{
            'columns':':not(:last-child)'
          },
          'text':'<i class="fa fa-download fa-fw"></i> Download Excel'
        }
      ]
    })
  });
  $('.input-daterange').datepicker({
	format: "yyyy-mm-dd",
	endDate: "{{date('Y-m-d',strtotime("+7days"))}}"
	});
</script>


@endsection