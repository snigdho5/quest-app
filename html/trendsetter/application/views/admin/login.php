<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Quest Trendsetter Admin Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url()?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url()?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>dist/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css" media="screen">
    .input-group-btn>img{
      max-height: 34px;
    }
  </style>
</head>
<body class="hold-transition login-page">
  <div class="main-cont">

    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-sm-offset-3 text-center">
          <div class="login-box"><br>
            <img class="logo" src="<?=base_url().'uploads/logo_icon/'.$site[0]['logo']?>" alt="logo">
            <!-- /.login-logo -->
            <div class="login-box-body">
              <?php if (isset($err_msg)):?>
                <p class="text-danger"><i class="fa fa-warning fa-fw"></i> <?=$err_msg?></p>
              <?php endif?>


              <form action="" method="post">
                <div class="form-group has-feedback">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
                    <input type="text" class="form-control" placeholder="Username" required name="username" value="<?=set_value('username')?>">

                  </div>
                  <?=form_error('username', '<p class="text-danger">', '</p>')?>
                </div>
                <div class="form-group has-feedback">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                    <input type="password" class="form-control" placeholder="Password" required name="password" value="<?=set_value('password')?>">
                  </div>
                  <?=form_error('password', '<p class="text-danger">', '</p>')?>
                </div>
                <div class="form-group has-feedback">
                  <div class="input-group">
                    <span class="input-group-btn"><?=$capData['img']?></span>
                    <input type="captcha" class="form-control" maxlength="5" placeholder="Enter captcha" required name="captcha" value="">
                  </div>
                  <?=form_error('captcha', '<p class="text-danger">', '</p>')?>
                </div>
                <div class="row">
                  <!-- /.col -->
                  <div class="col-xs-12">
                    <button type="submit" class="btn  btn-block btn-flat">Login</button>
                  </div>
                  <!-- /.col -->
                </div>
              </form>

            </div>
            <!-- /.login-box-body -->
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?=base_url()?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url()?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?=base_url()?>plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
