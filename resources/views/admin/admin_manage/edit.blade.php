@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Admin
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/admin_manage/">Manage Admins</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="box">
      <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box-body">
          <div class="form-group">
            <label class="control-label col-sm-2">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter name" name="name" required value="{{ $data->name }}">
              @if($errors->first('name')) <p class="text-danger">{{ $errors->first('name') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Role</label>
            <div class="col-sm-10">
              <select class="form-control" name="role" required>
                <option value="" selected disabled>--- Choose ---</option>
                @foreach($roleData as $value)
                  <option value="{{ $value->id }}" {{ $data->role==$value->id ? 'selected':'' }}>{{ $value->title }}</option>
                @endforeach
              </select>
              @if($errors->first('role')) <p class="text-danger">{{ $errors->first('role') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Username</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter username" name="username" required value="{{ $data->username }}">
              @if($errors->first('username')) <p class="text-danger">{{ $errors->first('username') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Password</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" placeholder="Enter password" name="password">
              @if($errors->first('password')) <p class="text-danger">{{ $errors->first('password') }}</p> @endif
            </div>
          </div>


          <div class="form-group">
            <label class="control-label col-sm-2">Active</label>
            <div class="col-sm-10">
              <select class="form-control" name="active" required>
                <option value="1" {{ $data->active == '1'?'selected':'' }}>Yes</option>
                <option value="0" {{ $data->active == '0'?'selected':'' }}>No</option>
              </select>
              @if($errors->first('active')) <p class="text-danger">{{ $errors->first('active') }}</p> @endif
            </div>
          </div>
        </div>
        <div class="box-footer text-right">
          <a class="btn btn-primary pull-left" href="admin/admin_manage/">Back</a>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function() {
    $('[name="icon"]').select2({
      templateResult: setIcon,
      templateSelection: setIcon
    });
  });
  function setIcon (option) {
    if (!option.id) { return option.text; }
    var $option = $('<span><i class="fa fa-'+option.text+'" style="width:30px"></i> '+option.text+'</span>');
    return $option;
  }
</script>


@endsection