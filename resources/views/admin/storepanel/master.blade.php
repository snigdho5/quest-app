<!DOCTYPE html>
<html>
  <head>
    <base href="{{config('app.base_url')}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.name')}} Store/Dine Panel</title>
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
        <a href="admin/store-panel/dashboard/" class="logo">
          <span class="logo-lg"><span class="logo-lg">{{ get_anydata('store',\Session::get('store_id'),'name') }}</span></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="admin/store-panel/logout" >
                  <i class="fa fa-sign-out fa-lg"></i>
                  <span class="hidden-xs">Logout</span>
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </header>

       <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <li>
              <a href="admin/store-panel/dashboard/">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            @if (get_anydata('store',\Session::get('store_id'),'s_type') == 'dine')
              <li>
                <a href="admin/store-panel/dinenwin/">
                  <i class="fa fa-cutlery"></i> <span>Dine n Win</span>
                </a>
              </li>
            @endif
            <li>
              <a href="admin/store-panel/apponlyoffer">
                <i class="fa fa-percent"></i> <span>App only offer</span>
              </a>
            </li>
            <li>
              <a href="admin/store-panel/employees/">
                <i class="fa fa-users"></i> <span>Manage Employees</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      @yield('content')

      <footer class="main-footer">
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
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $('select').select2({ width: '100%' });
      $('body').on( 'init.dt', function ( e, ctx ) {
        $('.dataTables_wrapper select').select2({ width: '70px' });
      });

    </script>
  </body>
</html>