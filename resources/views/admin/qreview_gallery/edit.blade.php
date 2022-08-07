@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Gallery of '{{ get_anydata('qreview',$q_id, 'title') }}'
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/qreview">Stores</a></li>
      <li><a href="admin/qreview/{{ $q_id }}/gallery">Gallery</a></li>
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
                <p><b>Website Image:</b></p>
                @if($data->image)
                <img src="{{ asset('storage/qreview_gallery/actual/'.$data->image) }}" alt="..." class="img-responsive">
                @else
                No image found.
                @endif
                <hr>
                <p><b>App Image:</b></p>
                @if($data->app_image)
                <img src="{{ asset('storage/qreview_gallery/app/'.$data->app_image) }}" alt="..." class="img-responsive">
                @else
                No image found.
                @endif
              </div>
              <div class="col-sm-10">

                <div class="form-group">
                  <label class="control-label col-sm-2">Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" required placeholder="Enter Title" name="title" value="{{ $data->title }}">
                    @if($errors->first('title')) <p class="text-danger">{{ $errors->first('title') }}</p> @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Website Image (JPG)</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" name="imagefile" placeholder="Select Image" accept=".jpeg,.jpg">
                    @if($errors->first('imagefile')) <p class="text-danger">{{ $errors->first('imagefile') }}</p> @endif
                  </div>
                </div>

                {{-- <div class="form-group">
                  <label class="control-label col-sm-2">App Image (JPG)</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" name="aimagefile" placeholder="Select Image" accept=".jpeg,.jpg">
                    @if($errors->first('aimagefile')) <p class="text-danger">{{ $errors->first('aimagefile') }}</p> @endif
                  </div>
                </div> --}}

                {{-- <div class="form-group">
                  <label class="control-label col-sm-2">Featured</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="featured" required>
                      <option value="1" {{ $data->featured=='1'?'selected':'' }}>Yes</option>
                      <option value="0" {{ $data->featured=='0'?'selected':'' }}>No</option>
                    </select>
                    @if($errors->first('featured')) <p class="text-danger">{{ $errors->first('featured') }}</p> @endif
                  </div>
                </div> --}}

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
                  <a class="btn btn-primary pull-left waves-effect" href="admin/qreview/{{ $q_id }}/gallery">Back</a>
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



@endsection