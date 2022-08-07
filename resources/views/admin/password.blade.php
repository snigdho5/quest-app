@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Change Password
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Change Password</li>
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
      <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box-body">
          <div class="form-group">
            <label class="control-label col-sm-2">New Password</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" placeholder="Enter new password" name="password" required>
              @if($errors->first('password')) <p class="text-danger">{{ $errors->first('password') }}</p> @endif
            </div>            
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Confirm Password</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" placeholder="Enter confirm password" name="password_confirmation" required>
              @if($errors->first('password_confirmation')) <p class="text-danger">{{ $errors->first('password_confirmation') }}</p> @endif
            </div>            
          </div>
        </div>
        <div class="box-footer text-right">
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </section>
  <!-- /.content -->
</div>


@endsection