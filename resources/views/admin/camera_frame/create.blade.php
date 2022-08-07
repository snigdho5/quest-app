@extends('admin.layout.master')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Frame
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/camera_frame">Camera Frame</a></li>
      <li class="active">Create</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">

    <div class="box">
      <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box-body">

          <div class="form-group">
            <label class="control-label col-sm-2">Image (PNG)</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="imagefile" required placeholder="Select Image" accept=".png">
              @if($errors->first('imagefile')) <p class="text-danger">{{ $errors->first('imagefile') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Active</label>
            <div class="col-sm-10">
              <select class="form-control" name="active" required>
                <option value="1" selected>Yes</option>
                <option value="0">No</option>
              </select>
              @if($errors->first('active')) <p class="text-danger">{{ $errors->first('active') }}</p> @endif
            </div>
          </div>
        </div>
        <div class="box-footer text-right">
          <a class="btn btn-primary pull-left" href="admin/camera_frame">Back</a>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


@endsection