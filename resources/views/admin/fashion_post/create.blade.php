@extends('admin.layout.master')
@section('content')

<link rel="stylesheet" href="bower_components/jquery-Tags-Input/dist/jquery.tagsinput.min.css">
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Post
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/fashion_post">Fashion Post</a></li>
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
            <label class="control-label col-sm-2">Store</label>
            <div class="col-sm-10">
              <select class="form-control" name="store_id" required>
                <option value="" selected disabled>--- Choose ---</option>
                @foreach($store as $value)
                  <option value="{{ $value->id }}" {{ old('store_id')==$value->id ? 'selected':'' }}>{{ $value->name }}</option>
                @endforeach
              </select>
              @if($errors->first('store_id')) <p class="text-danger">{{ $errors->first('store_id') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required placeholder="Enter title" name="title" value="{{ old('title') }}">
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
            <label class="control-label col-sm-2">Tag</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required placeholder="Enter tag" name="tag" value="{{ old('tag') }}">
              @if($errors->first('tag')) <p class="text-danger">{{ $errors->first('tag') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Link</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" required placeholder="Enter link" name="link" value="{{ old('link') }}">
              @if($errors->first('link')) <p class="text-danger">{{ $errors->first('link') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Post Time</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter date time" name="post_time" value="{{ old('post_time') }}">
              @if($errors->first('post_time')) <p class="text-danger">{{ $errors->first('post_time') }}</p> @endif
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
          <a class="btn btn-primary pull-left" href="admin/fashion_post">Back</a>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="bower_components/jquery-Tags-Input/dist/jquery.tagsinput.min.js"></script>

<script>
  $(document).ready(function() {
    $('[name="post_time"]').datetimepicker({format: 'YYYY-MM-DD hh:mm A'});
    $('[name="tag"]').tagsInput({'width':'100%'});
  });
</script>

@endsection