@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Qauthor
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/qauthor/">Qauthor</a></li>
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
            <label class="control-label col-sm-2">Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter title name" name="title" required value="{{ $data->title }}">
              @if($errors->first('title')) <p class="text-danger">{{ $errors->first('title') }}</p> @endif
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-sm-2">About Author</label>
            <div class="col-sm-10">
              <textarea id="content" class="form-control" name="content" rows="10">{{ $data->content }}</textarea>
              @if($errors->first('content')) <p class="text-danger">{{ $errors->first('content') }}</p> @endif
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
          <a class="btn btn-primary pull-left" href="admin/qauthor/">Back</a>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="bower_components/ckeditor/ckeditor.js"></script>

<script>
  $(document).ready(function() {
     CKEDITOR.replace('content');
  });
  
</script>


@endsection