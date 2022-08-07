@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Deal of '{{ get_anydata('store',$store_id, 'name') }}'
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/store">Stores</a></li>
      <li><a href="admin/store/{{ $store_id }}/deal">Deal</a></li>
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
                <img src="{{ asset('storage/store_deal/actual/'.$data->image) }}" alt="..." class="img-responsive">
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
                  <label class="control-label col-sm-2">Description</label>
                  <div class="col-sm-10">
                    <textarea rows="3" class="form-control" required placeholder="Enter description" name="description">{{ $data->description }}</textarea>
                    @if($errors->first('description')) <p class="text-danger">{{ $errors->first('description') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">For Beacon</label>
                  <div class="col-sm-10">

                    @if(get_anydata('store',$store_id, 'beacon_id') == 0)
                      <input type="hidden" required name="beacon_type" value="0">
                      <select class="form-control" disabled>
                        <option selected>Beacon not available!</option>
                      </select>
                    @else
                      <select class="form-control" name="beacon_type" required>
                        <option value="1" {{ $data->beacon_type=='1'?'selected':'' }}>Yes</option>
                        <option value="0" {{ $data->beacon_type=='0'?'selected':'' }}>No</option>
                      </select>
                    @endif

                    @if($errors->first('beacon_type')) <p class="text-danger">{{ $errors->first('beacon_type') }}</p> @endif
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
                    <label class="control-label col-sm-2">Start Date</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" placeholder="Enter start date" name="start_date" value="{{ $data->start_date }}">
                      @if($errors->first('start_date')) <p class="text-danger">{{ $errors->first('start_date') }}</p> @endif
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2">End Date</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" placeholder="Enter end date" name="end_date" value="{{ $data->end_date }}">
                      @if($errors->first('end_date')) <p class="text-danger">{{ $errors->first('end_date') }}</p> @endif
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-sm-2">Post Time</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" placeholder="Enter date time" name="post_time" value="{{ $data->post_time }}">
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
              </div>

              <div class="col-sm-12">
                <div class="box-footer text-right">
                  <a class="btn btn-primary pull-left waves-effect" href="admin/store/{{ $store_id }}/deal">Back</a>
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

    $('[name="start_date"]').datepicker({ format: 'yyyy-mm-dd'});
    $('[name="end_date"]').datepicker({ format: 'yyyy-mm-dd'});
  });

</script>

@endsection