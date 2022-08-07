@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Entry Settings
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Entry Settings</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    @if(session('success'))
      <p class="alert alert-success"><i class="fa fa-fw fa-check"></i>{{ session('success') }}</p>
    @endif
    @if(session('error'))
      <p class="alert alert-danger"><i class="fa fa-fw fa-warning"></i>{{ session('error') }}</p>
    @endif

    <div class="box">
      <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box-body">
          
          <div class="form-group">
            <label class="control-label col-sm-2">Terms and Conditions</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="content" name="terms" rows="5">{{ old('terms',$data->terms) }}</textarea>
              @if($errors->first('terms')) <p class="text-danger">{{ $errors->first('terms') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Reminder Before</label>
            <div class="col-sm-10">
              <div class="input-group">
                <input type="number" class="form-control" name="reminder_before" placeholder="Enter the number of minutes before booking timeout." required value="{{ $data->reminder_before }}">
                <span class="input-group-addon">Minutes</span>
                @if($errors->first('reminder_before')) <p class="text-danger">{{ $errors->first('reminder_before') }}</p> @endif
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Booking Limit</label>
            <div class="col-sm-10">
              <div class="input-group">
                <input type="number" class="form-control" name="slot_limit" placeholder="Enter the number booking allowed per slot." required value="{{ $data->slot_limit }}">
                @if($errors->first('slot_limit')) <p class="text-danger">{{ $errors->first('slot_limit') }}</p> @endif
              </div>
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
        <div class="box-footer text-right">
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </section>
  <!-- /.content -->
</div>

<!-- /.content-wrapper -->
<script src="bower_components/select2/dist/js/select2.min.js"></script>
<script src="bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(document).ready(function() {
    $('select').select2();
    CKEDITOR.replace('content');
  });
</script>

@endsection


