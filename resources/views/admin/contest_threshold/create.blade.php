@extends('admin.layout.master')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Contest Threshold
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/contest/{{ $contest_id }}/threshold/">Contest Threshold</a></li>
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
            <label class="control-label col-sm-2">Percentage</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" class="form-control" placeholder="Enter percentage" name="percentage" required value="{{ old('percentage') }}">
              @if($errors->first('percentage')) <p class="text-danger">{{ $errors->first('percentage') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Description</label>
            <div class="col-sm-10">
              <textarea id="description" class="form-control" required name="content" rows="5">{{ old('content') }}</textarea>
              @if($errors->first('content')) <p class="text-danger">{{ $errors->first('content') }}</p> @endif
            </div>
          </div>

          
          <div class="form-group">
            <label class="control-label col-sm-2">Max Discount</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" class="form-control" placeholder="Enter max discount" name="max_discount" required value="{{ old('max_discount') }}">
              @if($errors->first('max_discount')) <p class="text-danger">{{ $errors->first('max_discount') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Min Transaction</label>
            <div class="col-sm-10">
              <input type="number" step="0.01" class="form-control" placeholder="Enter min transaction" name="min_trans" required value="{{ old('min_trans') }}">
              @if($errors->first('min_trans')) <p class="text-danger">{{ $errors->first('min_trans') }}</p> @endif
            </div>
          </div>

          
          <div class="form-group">
            <label class="control-label col-sm-2">For</label>
            <div class="col-sm-10">
              <select class="form-control" name="type" required>
                <option value="1" selected>Dine</option>
                <option value="0">Food Court</option>
              </select>
              @if($errors->first('type')) <p class="text-danger">{{ $errors->first('type') }}</p> @endif
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
          <a class="btn btn-primary pull-left" href="admin/contest/{{ $contest_id }}/threshold/">Back</a>
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
    CKEDITOR.replace('description');
    CKEDITOR.replace('terms');
    $('[name="form_date"]').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
    $('[name="to_date"]').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});

    $("#dine_ids").select2({
        maximumSelectionLength: 10
    });
  });


//   function add_contactno(btn) {
//   var index = $('#add_contactno>div').length;

//   var input = $('<div class="input-group"><select class="form-control" name="dine_ids[]"  required>
//     @foreach($data as $key=>$value)<option value="{{$value->id}}">{{$value->name}}</option>@endforeach</select><span class="input-group-btn"><button type="button" onclick="$(this).closest(`.input-group`).remove()" class="btn btn-danger waves-effect"><i class="fa fa-close" aria-hidden="true"></i></button></span></div>');
//   $('#add_contactno').append(input);

// }


 
$(document).on('change', '.phonePrimaryCheck', function(event) {
  $('.phonePrimaryCheck').prop('checked', false);
  $(this).prop('checked', true);
});

</script>


@endsection