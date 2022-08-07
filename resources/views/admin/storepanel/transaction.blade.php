@extends('admin.storepanel.master')

@section('content')

      <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
      <div class="content-wrapper">
        <section class="content">
          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style="display:block">Claimed App Exclusive Offers List</h3>
            </div>
            <div class="box-body">   
              <form class="row" action="" method="get" enctype="multipart/form-data">
                  <div class="col-sm-5">
                    <div class="input-group"><span class="input-group-addon">From Date</span><input type="text" name="start_date" value="{{$start_date}}" class="form-control" placeholder="Enter from date" required autocomplete="off"></div>
                  </div>
                  <div class="col-sm-5">
                    <div class="input-group"><span class="input-group-addon">To Date</span><input type="text" name="end_date" value="{{$end_date}}" class="form-control" placeholder="Enter to date" required autocomplete="off"></div>
                  </div>
                  
                  <div class="col-sm-2">
                    <button class="btn btn-block btn-warning btn-sm">Filter</button>
                  </div>
              </form>
              <hr>
              <table id="listtable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Coupon</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Offer</th>
                    <th>Amount (Rs.)</th>
                    <th>Staff</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data as $key=>$value)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->updated_at->format('M d, Y - h:i a')}}</td>
                    <td>{{$value->code}}</td>
                    <td>{{$value->user->name}}</td>
                    <td>{{$value->user->phone}}</td>
                    <td>{{$value->user->email}}</td>
                    <td>{{$value->offer_title}}</td>
                    <td>{{$value->amount}}</td>
                    <td>{{$value->staff_name}} <br><small>({{$value->staff_phone}})</small></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

        </section>
      </div>

    <script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="bower_components/datatables.net/js/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>
    <script src="bower_components/datatables.net/js/Buttons-1.4.2/js/buttons.bootstrap.min.js"></script>
    <script src="bower_components/datatables.net/js/Buttons-1.4.2/js/buttons.html5.min.js"></script>

    <script>
      $(document).ready(function() {
        $('[name="start_date"]').datetimepicker({format: 'YYYY-MM-DD'});
        $('[name="end_date"]').datetimepicker({format: 'YYYY-MM-DD'});

       $('#listtable').DataTable({
          dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
          buttons: [
            {
              'filename':'Claimed_offer_list_{{date('Y-m-d')}}',
              'extend':'excelHtml5',
              'exportOptions':{
                'modifier': {
                  'search': 'none',
                  'order': 'applied'
                }
              },
              'text':'<i class="fa fa-download fa-fw"></i> Export Data'
            },
          ]
        })
      });
    </script>

@endsection