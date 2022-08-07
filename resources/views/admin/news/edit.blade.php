@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit News
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/news/">News</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">

    <div class="box">
      <div class="box-body">
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
            <div class="row">

              <div class="col-sm-12">

                <div class="form-group">
                  <label class="control-label col-sm-2">Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter title" name="title" required value="{{ $data->title }}">
                    @if($errors->first('title')) <p class="text-danger">{{ $errors->first('title') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Link</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter link" name="link" required value="{{ $data->link }}">
                    @if($errors->first('link')) <p class="text-danger">{{ $errors->first('link') }}</p> @endif
                  </div>
                </div>

              </div>
              <div class="col-sm-12">
                <p class="label-hr">Page Setting</p>
              </div>

              <div class="col-sm-12">
                <div class="form-group">
                  <label class="control-label col-sm-2">Post Time</label>
                  <div class="col-sm-10">
                    <div class="form-line">
                      <input type="text" class="form-control" required placeholder="Enter date time" name="post_time" value="{{ $data->post_time }}">
                    </div>
                    @if($errors->first('post_time')) <p class="text-danger">{{ $errors->first('post_time') }}</p> @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Active</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="active" required>
                      <option value="" selected disabled>--Please Select--</option>
                      <option value="1" {{ $data->active=='1'?'selected':'' }}>Yes</option>
                      <option value="0" {{ $data->active=='0'?'selected':'' }}>No</option>
                    </select>
                    @if($errors->first('active')) <p class="text-danger">{{ $errors->first('active') }}</p> @endif
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="box-footer text-right">
                  <a class="btn btn-primary pull-left waves-effect" href="admin/news/">Back</a>
                  <button type="submit" class="btn btn-success waves-effect">Save</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script src="bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(document).ready(function() {
    $('[name="post_time"]').datetimepicker({format: 'YYYY-MM-DD hh:mm A'});
  });

</script>



@endsection