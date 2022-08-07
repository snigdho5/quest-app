<!DOCTYPE html>
<html>
<head>
  <base href="{{config('app.base_url')}}">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> {{config('app.name')}} Admin Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" type="image/png" href="{{ asset('storage/logo_icon/'.get_anydata('site_setting',1,'favicon')) }}" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

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
<body class="hold-transition login-page" style="background-image: url({{ asset('storage/logo_icon/'.get_anydata('site_setting',1,'login_back')) }})">
  <div class="main-cont">

    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-sm-offset-3 text-center">
          <div class="login-box"><br>
            <h2>Store Login</h2>
            <div class="login-box-body">
              @if ($errors->any())
                <p class="text-danger"><i class="fa fa-warning fa-fw"></i> {{ $errors->first() }}</p>
              @endif


              <form action="" method="post">
                {{ csrf_field() }}
                <div class="form-group has-feedback">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-fw fa-hashtag"></i></span>
                    <input type="text" class="form-control" placeholder="Store ID" required name="id" value="{{old('id')}}">

                  </div>
                </div>
                <div class="form-group has-feedback">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i></span>
                    <input type="password" class="form-control" placeholder="Password" required name="password" value="{{old('password')}}">
                  </div>
                </div>
                <div class="form-group has-feedback">
                  <div class="input-group">
                    <span class="input-group-btn"><img src="{{  session('captchaImgData') }}" alt=""></span>
                    <input type="captcha" class="form-control" maxlength="5" placeholder="Enter captcha" required name="captcha" value="">
                  </div>
                </div>
                <div class="row">
                  <!-- /.col -->
                  <div class="col-xs-12">
                    <button type="submit" class="btn bg-olive btn-block btn-flat">Verify and Login</button>
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
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
