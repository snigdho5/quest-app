@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Banner
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/banner">Banner</a></li>
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
              <div class="col-sm-2">
                <p><b>Image:</b></p>
                @if($data->image)
                <img src="{{ asset('storage/banner/actual/'.$data->image) }}" alt="..." class="img-responsive">
                @else
                No image found.
                @endif
                <hr>

                <p><b>Square Image:</b></p>
                @if($data->image)
                <img src="{{ asset('storage/banner/thumb/'.$data->sq_image) }}" alt="..." class="img-responsive">
                @else
                No image found.
                @endif
              </div>
              <div class="col-sm-10">

                <div class="form-group">
                  <label class="control-label col-sm-2">Link</label>
                  <div class="col-sm-10">
                    <input type="url" class="form-control" placeholder="Enter link" name="link" required value="{{ $data->link }}">
                    @if($errors->first('link')) <p class="text-danger">{{ $errors->first('link') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Link Open</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="link_open" required>
                      <option value="1" {{ $data->link_open=='1'?'selected':'' }}>New Tab</option>
                      <option value="0" {{ $data->link_open=='0'?'selected':'' }}>Self Tab</option>
                    </select>
                    @if($errors->first('link_open')) <p class="text-danger">{{ $errors->first('link_open') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Image (JPG)</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" name="imagefile" placeholder="Select Image" accept=".jpeg,.jpg">
                    @if($errors->first('imagefile')) <p class="text-danger">{{ $errors->first('imagefile') }}</p> @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Modile Image (JPG)</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" name="sq_imagefile" placeholder="Select Image" accept=".jpeg,.jpg">
                    @if($errors->first('sq_imagefile')) <p class="text-danger">{{ $errors->first('sq_imagefile') }}</p> @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Post Time</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" required placeholder="Enter date time" name="post_time" value="{{ $data->post_time }}">
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
                  <a class="btn btn-primary pull-left waves-effect" href="admin/banner">Back</a>
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

<script>
  $(document).ready(function() {
    $('[name="post_time"]').datetimepicker({format: 'YYYY-MM-DD hh:mm A'});
  });

</script>

@endsection