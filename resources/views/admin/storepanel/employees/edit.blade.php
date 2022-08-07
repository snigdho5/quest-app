@extends('admin.storepanel.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <div class="box">
      <div class="box-header">
        <h3 class="box-title" style="display:block">Edit Employee</h3>
      </div>
      <div class="box-body">
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
            <div class="row">
              <div class="col-sm-12">

                <div class="form-group">
                  <label class="control-label col-sm-2">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter name" name="name" required value="{{ $data->name }}">
                    @if($errors->first('name')) <p class="text-danger">{{ $errors->first('name') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Phone</label>
                  <div class="col-sm-10">
                    <input type="text" pattern="[0-9]{10}" title="10 Digit mobile number" class="form-control" placeholder="Enter phone" name="phone" required value="{{ $data->phone }}">
                    @if($errors->first('phone')) <p class="text-danger">{{ $errors->first('phone') }}</p> @endif
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
                  <a class="btn btn-primary pull-left waves-effect" href="admin/store-panel/employees">Back</a>
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