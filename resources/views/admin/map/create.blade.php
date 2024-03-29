@extends('admin.layout.master')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Map
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/map">Maps</a></li>
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
            <label class="control-label col-sm-2">Floor</label>
            <div class="col-sm-10">
              <select class="form-control" name="floor" required>
                <option value="" selected disabled>--- choose ---</option>
                <option>FIRST</option>
                <option>SECOND</option>
                <option>THIRD</option>
                <option>FOURTH</option>
                <option>FIFTH</option>
                <option>SIXTH</option>
                <option>BASEMENT</option>
                <option>GROUND</option>
              </select>
              @if($errors->first('floor')) <p class="text-danger">{{ $errors->first('floor') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="title" required placeholder="Enter Title">
              @if($errors->first('title')) <p class="text-danger">{{ $errors->first('title') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Image (JPG)</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="imagefile" required placeholder="Select Image" accept=".jpeg,.jpg">
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
          <a class="btn btn-primary pull-left" href="admin/map">Back</a>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection