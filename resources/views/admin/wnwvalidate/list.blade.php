<!DOCTYPE html>
<html>
  <head>
    <base href="{{config('app.base_url')}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.name')}} Admin Panel</title>
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
                <a href="admin/walknwin-validate/logout" >
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
          <div class="box">
            <div class="box-header">
              <h3 class="box-title" style="display:block">Claimed Offer List</h3>
            </div>
            <div class="box-body">
              <table id="listtable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Code</th>
                    <th>Offer</th>
                    <th>Claimed On</th>
                    <th>Redeemed On</th>
                    <th class="text-right">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($data as $value)
                  <tr>
                    <td>{{ $value->user->name }}</td>
                    <td>{{ $value->user->email }}</td>
                    <td>{{ $value->user->phone }}</td>
                    <td>{{ $value->code }}</td>
                    <td>{{ $value->offer }}</td>
                    <td>{{ $value->redeem_date->format('M d, Y - h:i a') }}</td>
                    <td>{{ $value->used_date==''?'':$value->used_date->format('M d, Y - h:i a') }}</td>
                    <td class="text-right">

                      @if($value->redeem_date->diffInDays(date('Y-m-d'))+1 > $value->redeem_within-1)
                        <span>Expired</span>
                      @elseif($value->used_date == '')
                        <a class="btn btn-success btn-xs"  onclick="return confirm('Once redeemed it cannot be chaged. Are you sure you want to continue?')" href="admin/walknwin-validate/update/{{ $value->id }}">Redeemed</a>
                        <br>
                        <small>{{ 'Expires in '.($value->redeem_within - $value->redeem_date->diffInDays(date('Y-m-d'))-1).' days' }}</small>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
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
    <script>
      $(document).ready(function() {
        $('#listtable').DataTable()
      });
    </script>

  </body>
</html>