<!DOCTYPE html>
<html>
  <head>
    <base href="{{config('app.base_url')}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.name')}} Dine Panel</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" href="{{ asset('storage/logo_icon/'.get_anydata('site_setting',1,'favicon')) }}" />
    <link rel="stylesheet" href="dist/css/skins/skin-green.min.css">

    <link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="bower_components/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.css"> 
    <link rel="stylesheet" href="bower_components/datatables.net/js/Buttons-1.4.2/css/buttons.bootstrap.min.css"/>

    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
  </head>

  <body class="hold-transition skin-green sidebar-mini fixed">
    <div class="wrapper">
      <header class="main-header">
        <a href="#" class="logo">
          <span class="logo-lg">{{ get_anydata('store',\Session::get('store_id'),'name') }}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="admin/contest-validate/logout" >
                  <i class="fa fa-sign-out fa-lg"></i>
                  <span class="hidden-xs">Logout</span>
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </header>


      <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
      <div class="content-wrapper" style="margin-left: 0">
        <section class="content">
          @if(session('success'))
            <p class="alert alert-success"><i class="fa fa-fw fa-check"></i>{{ session('success') }}</p>
          @endif
          @if(isset($message['error']))
            <p class="alert alert-danger"><i class="fa fa-fw fa-warning"></i>{{ $message['error'] }}</p>
          @endif
          <div class="row">
            <div class="col-sm-3">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title" style="display:block">Search User</h3>
                </div>
                <div class="box-body">
                  <form action="" method="post" enctype="multipart/form-data">
                    {{ csrf_field()}}
                    <div class="form-group input-group input-group-sm">
                      <span class="input-group-addon">User Unique Code</span>
                      <input type="text" name="unique_code" autocomplete="off" class="form-control" value="{{request('unique_code')}}" placeholder="Enter user unique code" required>
                      <span class="input-group-btn"><input type="submit" name="filter" class="btn btn-block btn-success" value="Search"></span>
                    </div>
                    @if(isset($contest->thresholdPercentage) && !isset($message['error']))
                        
                      <div class="form-group input-group input-group-sm">
                        <span class="input-group-addon">Customer Name:</span>
                        <input type="text" class="form-control" value="{{$data->user->name}}" readonly>
                      </div>
                      <div class="form-group input-group input-group-sm">
                        <span class="input-group-addon">Customer Phone:</span>
                        <input type="text" class="form-control" value="{{$data->user->phone}}" readonly>
                      </div>
                      <div class="form-group input-group input-group-sm">
                        <span class="input-group-addon">Customer Email:</span>
                        <input type="text" class="form-control" value="{{$data->user->email}}" readonly>
                      </div>
                      <div class="form-group">
                        <div class="input-group input-group-sm">
                          <span class="input-group-addon">Current Discount:</span>
                          @php
                              $index = $contest->thresholdPercentage->search($contest->userTransaction);
                              if($index!==false) $discount = $contest->thresholdPercentage->get($index+1);
                              else $discount = $contest->thresholdPercentage->get(0);
                              if($contest->thresholdPercentage->count()==$index+1) $discount = $contest->thresholdPercentage->get($index);
                          @endphp
                          <input type="text" class="form-control" value="{{$discount}}%" readonly>
                        </div>
                        <p class="text-danger text-right"><i class="fa fa-info-circle fa-fw"></i>Minimum Bill Amount: <span id="min_bill">{{$contest->thresholdDetails->where('percentage',$discount)->where('type',$type)->first()->min_trans}}</p>
                        {{-- <br><span class="badge">Max discount: <span id="max_discount">{{$contest->thresholdDetails->where('percentage',$discount)->first()->max_discount}}</span></span> --}}
                      </div>

                      <input type="hidden" name="percentage" value="{{$discount}}">
                      <div class="form-group">
                        <label>Bill Amount (before discount):</label>
                        <div class="input-group">
                          <input type="number" step="0.01" class="form-control" onkeyup="calculateAmount(this)" placeholder="Enter Bill Amount before discount" name="trans_amount"  value="">
                        </div>
                          <p class="error-amount text-danger" style="display: none;"></p>
                      </div>
                      
                      <div class="form-group">
                        <label>Bill Amount (after discount):</label>
                        <input type="text" class="form-control"  name="dis_amount"  value="" readonly="">
                      </div>

                      <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-block btn-warning button-submit" value="Submit" onclick="$(this).hide();" style="display: none">
                      </div>
                        
                      
                     
                    @endif
                    </form>
                </div>
              </div>
            </div>
            <div class="col-sm-9">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title" style="display:block">Previous Transaction List</h3>
                </div>
                <div class="box-body">   
                  <form class="row" action="" method="post" enctype="multipart/form-data">
                    {{ csrf_field()}}
                      <div class="col-sm-3">
                        <div class="input-group"><span class="input-group-addon">From Date</span><input type="text" name="start_date" value="{{request('start_date')}}" class="form-control" placeholder="Enter from date" required autocomplete="off"></div>
                      </div>
                      <div class="col-sm-3">
                        <div class="input-group"><span class="input-group-addon">To Date</span><input type="text" name="end_date" value="{{request('end_date')}}" class="form-control" placeholder="Enter to date" required autocomplete="off"></div>
                      </div>
                      <div class="col-sm-3">
                        <div class="input-group"><span class="input-group-addon">Dine</span>
                          <select name="dine_id" class="form-control" required>
                            <option value="all" {{request()->has('dine_id') == "all"?'selected':''}}>All</option>
                            @php
                              if($type == 1) $dines = $contest->dines;
                              if($type == 0) $dines = $contest->fc_outlets;
                            @endphp
                            @foreach($dines as $val)
                            <option value="{{$val->dine_id}}" {{$val->dine_id==(request()->has('dine_id')?request('dine_id'):session('store_id'))?'selected':''}}>{{$val->dineDetails->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <button class="btn btn-block btn-warning btn-sm">Filter</button>
                      </div>
                  </form>
                  <hr>
                  <table id="listtable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Dine</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Discount(%)</th>
                        <th>Bill Amount(Rs)</th>
                        <th>Discount(Rs)</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($allTrandsaction as $value)
                      <tr>
                        <td>{{$value->trans_date}}</td>
                        <td>{{$value->dineDetails->name}}</td>
                        <td>{{$value->participantDetails->user->name}}</td>
                        <td>{{$value->participantDetails->user->phone}}</td>
                        <td>{{$value->participantDetails->user->email}}</td>
                        {{-- <td>{{substr($value->participantDetails->user->phone,0,2)}}********{{substr($value->participantDetails->user->phone,-2,2)}}</td> --}}
                        {{-- <td>{{substr($value->participantDetails->user->email,0,3)}}*******{{substr($value->participantDetails->user->email,strpos($value->participantDetails->user->email,'@')-3)}}</td> --}}
                        <td>{{$value->percentage}}</td>
                        <td>{{$value->trans_amount}}</td>
                        <td>{{$value->trans_amount*($value->percentage/100)}}</td>
                        
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
        </section>
      </div>

      <footer class="main-footer" style="margin-left: 0">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.3.1
          </div>
          <strong>Copyright &copy; {{ date('Y') }}. {{config('app.name')}} </a>.</strong> All rights reserved.
      </footer>
    </div>
    <script src="bower_components/datatables.net/js/JSZip-2.5.0/jszip.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="bower_components/moment/min/moment.min.js"></script>
    <script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="bower_components/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="bower_components/fastclick/lib/fastclick.js"></script>
    <script src="bower_components/select2/dist/js/select2.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>

    <script>
      $('[name="start_date"]').datetimepicker({format: 'YYYY-MM-DD'});
      $('[name="end_date"]').datetimepicker({format: 'YYYY-MM-DD'});

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $save_btn = $(document).find('.box form .btn-success');
      $(document).bind('keydown', function(event) {
          if (event.ctrlKey || event.metaKey) {
            if(String.fromCharCode(event.which).toLowerCase() == 's'){
              event.preventDefault();
                  $save_btn.click();
            }
          }
      });

      if(typeof CKEDITOR !== 'undefined'){
        CKEDITOR.on('instanceReady', function () {
            $.each(CKEDITOR.instances, function (instance) {
                CKEDITOR.instances[instance].document.on("keydown", function(event) {
                  event = event.data.$;
                if (event.ctrlKey || event.metaKey) {
                  if(String.fromCharCode(event.which).toLowerCase() == 's'){
                    event.preventDefault();
                    $save_btn.click();
                  }
                }
            });
            });
        });
      }
      $('select').select2({ width: '100%' });
      $('body').on( 'init.dt', function ( e, ctx ) {
        $('.dataTables_wrapper select').select2({ width: '70px' });
      });

    </script>
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
          'filename':'Previous_Transaction_List_{{date('Y-m-d')}}',
          'extend':'excelHtml5',
          
          'text':'<i class="fa fa-download fa-fw"></i> Download'
        },
        {
          'filename':'Previous_Transaction List_{{date('Y-m-d')}}',
          'extend':'excelHtml5',
          'exportOptions':{
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

      function calculateAmount(input) {
        $('.error-amount').hide();
        var percentage = parseFloat($("input[name=percentage]").val());
        var transAmount = parseFloat($(input).val());
        var Minimumbill = parseFloat($('#min_bill').html());
        var Maxdiscount =parseFloat($('#max_discount').html());
        if(isNaN(transAmount)){
          $('.error-amount').show();
          $('.error-amount').html('Please enter bill amount.');
        }else{
          if(transAmount >= Minimumbill){
            var discount = (transAmount*percentage)/100;
          }else{
            var discount = 0;
          }

          if(discount > Maxdiscount){
            var result = transAmount-Maxdiscount;
          }else{
            var result = transAmount-discount;
          }
          
          
          $("input[name=dis_amount]").val(result);
          if(discount>0){ 
             $('.button-submit').show();
          }else{
            $('.error-amount').show();
            $('.error-amount').html('Minimum bill amount must be at least Rs.'+Minimumbill);
            $('.button-submit').hide();
          }
        }

      }
    </script>

  </body>
</html>