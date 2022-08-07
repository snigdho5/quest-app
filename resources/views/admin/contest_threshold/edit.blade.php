@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Contest
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/contest/{{ $contest_id }}/threshold/">Contest</a></li>
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
              <div class="form-group">
                <label class="control-label col-sm-2">Percentage</label>
                <div class="col-sm-10">
                  <input type="number" step="0.01" class="form-control" placeholder="Enter percentage" name="percentage" required value="{{ $data->percentage}}">
                  @if($errors->first('percentage')) <p class="text-danger">{{ $errors->first('percentage') }}</p> @endif
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2">Description</label>
                <div class="col-sm-10">
                  <textarea id="description" class="form-control" required name="content" rows="5">{{ $data->content }}</textarea>
                  @if($errors->first('content')) <p class="text-danger">{{ $errors->first('content') }}</p> @endif
                </div>
              </div>

              

              <div class="form-group">
                <label class="control-label col-sm-2">Max Discount</label>
                <div class="col-sm-10">
                  <input type="number" step="0.01" class="form-control" placeholder="Enter max discount" name="max_discount" required value="{{ $data->max_discount }}">
                  @if($errors->first('max_discount')) <p class="text-danger">{{ $errors->first('max_discount') }}</p> @endif
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2">Min Transaction</label>
                <div class="col-sm-10">
                  <input type="number" step="0.01"  class="form-control" placeholder="Enter min transaction" name="min_trans" required value="{{ $data->min_trans }}">
                  @if($errors->first('min_trans')) <p class="text-danger">{{ $errors->first('min_trans') }}</p> @endif
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2">For</label>
                <div class="col-sm-10">
                  <select class="form-control" name="type" required>
                    <option value="1" {{ $data->type=='1'?'selected':'' }}>Dine</option>
                    <option value="0" {{ $data->type=='0'?'selected':'' }}>Food Court</option>
                  </select>
                  @if($errors->first('type')) <p class="text-danger">{{ $errors->first('type') }}</p> @endif
                </div>
              </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Active</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="active" required>
                      <option value="1" {{ $data->active=='1'?'selected':'' }}>Yes</option>
                      <option value="0" {{ $data->active=='0'?'selected':'' }}>No</option>
                    </select>
                    @if($errors->first('active')) <p class="text-danger">{{ $errors->first('active') }}</p> @endif
                  </div>
                </div>

              <div class="col-sm-12">
                <div class="box-footer text-right">
                  <a class="btn btn-primary pull-left waves-effect" href="admin/contest/{{ $contest_id }}/threshold/">Back</a>
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
    
   CKEDITOR.replace('description');
    CKEDITOR.replace('terms');
    $('[name="form_date"]').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
    $('[name="to_date"]').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
  });



</script>

@endsection