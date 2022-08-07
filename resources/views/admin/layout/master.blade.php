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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
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
    
    <style>
      .material-icons {
        font-size: inherit !important;
        line-height: unset !important;
      }
    </style>
  </head>

  <body class="hold-transition skin-green sidebar-mini fixed">
    <div class="wrapper">
      <header class="main-header">
        <a href="admin/dashboard/" class="logo">
          <span class="logo-mini"><b>{{ config('app.name')[0] }}</b></span>
          <span class="logo-lg">{{ config('app.name') }}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-user-circle fa-lg"></i>
                  <span class="hidden-xs">{{auth()->guard('admin')->user()->name}}</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <p>
                      {{auth()->guard('admin')->user()->name}}
                      <small>{{get_anydata('admin_type',auth()->guard('admin')->user()->role,'title')}}</small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="admin/password/" class="btn btn-default btn-flat">Change Password</a>
                    </div>
                    <div class="pull-right">
                      <a href="admin/logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <li>
              <a href="admin/dashboard/">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            @php
              $parentMenu = $menuList->where('parent_id',0);
              $subMenu = $menuList->where('parent_id','>',0);
            @endphp

            @foreach ($subMenu as $menu)
              @if($parentMenu->where('id',$menu->parent_id)->count() == 0)
                @php
                  $parentMenu = $parentMenu->merge([0=>$menu->parent]);
                @endphp
              @endif
            @endforeach

            @php
              $parentMenu = $parentMenu->sortBy('priority');
            @endphp

            @foreach ($parentMenu as $menu)

            <li class="{{ $menu->link=='#'?'treeview':'' }}">
              <a href="{{ $menu->link=='#'?'javascript:void(0);':'admin/'.$menu->link }}">
                <i class="fa fa-{{ $menu->icon }}"></i> <span>{{ $menu->module }}</span>

                @if($menu->link=='#')
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                @endif

              </a>

              @if($menu->link=='#')
              <ul class="treeview-menu">
                @php
                  $subMenu = $menuList->where('parent_id',$menu->id)->sortBy('priority');
                @endphp

                @foreach ($subMenu as $child)
                  <li><a href="admin/{{ $child->link }}">{{ $child->module }}</a></li>
                @endforeach
              </ul>
              @endif
            </li>
            @endforeach

            @if(auth()->guard('admin')->user()->role =='1')
            <li class="treeview">
              <a href="#">
                <i class="fa fa-cogs"></i> <span>Backend Settings</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="admin/admin_module">Admin Module</a></li>
                <li><a href="admin/admin_type">Admin Type</a></li>
                <li><a href="admin/admin_manage">Manage Admins</a></li>
                <li><a href="admin/seq_db_admin_255/" target="_blank">Manage Database</a></li>
              </ul>
            </li>
            @endif
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
      $page_link = '{{ Request::segment(1).'/'.Request::segment(2) }}';

      $('.sidebar-menu a').each(function(index, el) {
        if($(el).attr('href') == $page_link){
          $(el).parent().addClass('active');
          $(el).closest('.treeview').addClass('active').addClass('menu-open');
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
      $('select:not(.no-select2)').select2({ width: '100%' });
      $('body').on( 'init.dt', function ( e, ctx ) {
        $('.dataTables_wrapper select').select2({ width: '70px' });
      });

    </script>
  </body>
</html>