@extends('admin.layout.master')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Beacon
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/beacon">Beacon</a></li>
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
            <label class="control-label col-sm-2">UUID</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required placeholder="Enter uuid" name="uuid" value="{{ old('uuid') }}">
              @if($errors->first('uuid')) <p class="text-danger">{{ $errors->first('uuid') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">MAC</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required placeholder="Enter mac" name="mac" value="{{ old('mac') }}">
              @if($errors->first('mac')) <p class="text-danger">{{ $errors->first('mac') }}</p> @endif
            </div>
          </div>


          <div class="form-group">
            <label class="control-label col-sm-2">Type</label>
            <div class="col-sm-10">
              <select class="form-control" name="type" required>
                <option value="" selected disabled>Select Type</option>
                <option value="1">Entry/Exit</option>
                <option value="0">Offer</option>
              </select>
              @if($errors->first('type')) <p class="text-danger">{{ $errors->first('type') }}</p> @endif
            </div>
          </div>

          <div class="form-group" id="type_1" style="display: none">
            <label class="control-label col-sm-2">Place</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter place" name="place" value="{{ old('place') }}">
              @if($errors->first('place')) <p class="text-danger">{{ $errors->first('place') }}</p> @endif
            </div>
          </div>
          <div class="form-group" id="type_0" style="display: none">
            <label class="control-label col-sm-2">Store</label>
            <div class="col-sm-10">
              <select class="form-control" name="store[]" multiple data-placeholder="Select store">
                @foreach($store as $key=>$value)}
                <option value="{{$value->id}}">{{$value->name}}</option>
                @endforeach
              </select>
              @if($errors->first('type')) <p class="text-danger">{{ $errors->first('type') }}</p> @endif
            </div>
          </div>

        </div>

        <div class="box-footer text-right">
          <a class="btn btn-primary pull-left" href="admin/beacon">Back</a>
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
    $('[name="type"]').trigger('change');
  });
  $('[name="type"]').change(function(event) {
    if($(this).val() == '1') {
      $('#type_1').show()
      $('#type_1 input').prop('required', 'true')
      $('#type_0').hide()
      $('#type_0 select').prop('required', '')
    }else{
      $('#type_0').show()
      $('#type_0 select').prop('required', 'true')
      $('#type_1').hide()
      $('#type_1 input').prop('required', '')
    }
  });
</script>
@endsection