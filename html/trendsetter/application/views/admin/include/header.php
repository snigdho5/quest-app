<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Quest Trendsetter Admin Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="image/png" href="<?=base_url().'uploads/logo_icon/'.get_anydata('arg_site_setting','favicon',1)?>" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url()?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url()?>bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="<?=base_url()?>bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?=base_url()?>dist/css/skins/skin-black.min.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?=base_url()?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?=base_url()?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>bower_components/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">

  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">



  <!-- scripts -->
  <!-- jQuery 3 -->
  <script src="<?=base_url()?>bower_components/jquery/dist/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="<?=base_url()?>bower_components/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?=base_url()?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- daterangepicker -->
  <script src="<?=base_url()?>bower_components/moment/min/moment.min.js"></script>
  <script src="<?=base_url()?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="<?=base_url()?>bower_components/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <!-- datepicker -->
  <script src="<?=base_url()?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="<?=base_url()?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <!-- Slimscroll -->
  <script src="<?=base_url()?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="<?=base_url()?>bower_components/fastclick/lib/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?=base_url()?>dist/js/adminlte.min.js"></script>



  <style type="text/css" media="screen">
    .colorbox{
      width: 20px;
      height: 20px;
      display: inline-block;
      margin: 2px 5px;
      vertical-align: middle;
      box-shadow: 0px 0px 2px rgba(0, 0, 0, .3);
    }
  </style>
</head>
<body class="hold-transition skin-black sidebar-mini fixed">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?=base_url()?>admin/dashboard/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>QT</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Quest </b>Trendsetter</span>
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
              <span class="hidden-xs"><?=$_SESSION['name']?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <p>
                  <?=$_SESSION['name']?>
                  <small><?=get_anydata('arg_admin_type','title',$_SESSION['role'])?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=base_url()?>admin/password/" class="btn btn-default btn-flat">Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="<?=base_url()?>admin/logout" class="btn btn-default btn-flat">Sign out</a>
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

        <?php
        $menuArr = array();
        foreach ($menuList as $key => $menu) {

          if($menu['active']=='1'){
            if($menu['parent_id']=='0'){
              $menuArr[] = array(
                'id' => $menu['id'],
                'parent_id' => false,
                'parent' => $menu['module'],
                'module' => $menu['module'],
                'icon' => $menu['icon'],
                'link' => $menu['link'],
                'show_before' => $menu['show_before'],
              );
            }elseif(get_anydata('arg_admin_module','active',$menu['parent_id']) == '1'){
              $parent = get_anydata('arg_admin_module','module',$menu['parent_id']);
              $parent_exist = array_search($parent, array_column($menuArr, 'parent'));

              if($parent_exist){
                $menuArr[$parent_exist]['child'][] = array(
                  'module' => $menu['module'],
                  'link' => $menu['link']
                );
              }else{
                $menuArr[] = array(
                  'id' => $menu['parent_id'],
                  'parent_id' => $menu['parent_id'],
                  'parent' => $parent,
                  'icon' => get_anydata('arg_admin_module','icon',$menu['parent_id']),
                  'show_before' => get_anydata('arg_admin_module','show_before',$menu['parent_id']),
                  'child' => array(array(
                    'module' => $menu['module'],
                    'link' => $menu['link']
                  ))
                );
              }
            }
          }

        }

        foreach ($menuArr as $key => $menu) {
          if($menu['show_before'] != '0'){
            $d_menu = array_search($menu['show_before'], array_column($menuArr, 'id'));
            if($d_menu){
              $move = array( $menu );
              array_splice( $menuArr, $d_menu, 0, $move );
              unset($menuArr[$key + 1]);
            }
          }
        }


        ?>

        <li>
          <a href="<?=base_url()?>admin/dashboard/">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <?php foreach ($menuArr as $key => $menu) {
        if($menu['parent_id']==false){?>
        <li>
          <a href="<?=base_url()?>admin/<?=$menu['link']?>">
            <i class="fa fa-<?=$menu['icon']?>"></i> <span><?=$menu['module']?></span>
          </a>
        </li>
        <?php }else{?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-<?=$menu['icon']?>"></i> <span><?=$menu['parent']?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php foreach ($menu['child'] as $key => $child) {?>
            <li><a href="<?=base_url()?>admin/<?=$child['link']?>"><?=$child['module']?></a></li>
            <?php } ?>
          </ul>
        </li>
        <?php }}
        if($_SESSION['role']=='1'){?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cogs"></i> <span>Site Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!-- <li><a href="<?=base_url()?>admin/navigation/">Website Navigation</a></li>
            
            <li><a href="<?=base_url()?>admin/link_data/">SEO &amp; Conversion Code</a></li> -->
            <li><a href="<?=base_url()?>admin/site_setting/">Site Information</a></li>
            <li><a href="<?=base_url()?>admin/admin_module/">Admin Panel Navigation</a></li>
            <!-- <li><a href="<?=base_url()?>admin/routing/">Routing</a></li> -->
            <li><a href="<?=base_url()?>admin/admin_type/">Admin Type</a></li>
            <li><a href="<?=base_url()?>admin/admin_manage/">Manage Admins</a></li>
            <!-- <li><a href="<?=base_url()?>admin/media_storage/">Media Storage</a></li> -->
          </ul>
        </li>
        <?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
