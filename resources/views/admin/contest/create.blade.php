@extends('admin.layout.master')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Contest
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/contest/">Contest</a></li>
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
            <label class="control-label col-sm-2">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter name" name="name" required value="{{ old('name') }}">
              @if($errors->first('name')) <p class="text-danger">{{ $errors->first('name') }}</p> @endif
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
            <label class="control-label col-sm-2">Form Date</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter form date" name="form_date" value="{{ old('form_date') }}">
              @if($errors->first('form_date')) <p class="text-danger">{{ $errors->first('form_date') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">To Date</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter to date" name="to_date" value="{{ old('to_date') }}">
              @if($errors->first('to_date')) <p class="text-danger">{{ $errors->first('to_date') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Terms</label>
            <div class="col-sm-10">
              <textarea id="terms" class="form-control" required name="terms" rows="5">{{ old('terms') }}</textarea>
              @if($errors->first('terms')) <p class="text-danger">{{ $errors->first('terms') }}</p> @endif
            </div>
          </div>

         

          <div class="form-group">
            <label class="control-label col-sm-2">Dine</label>
            <div class="col-sm-10 add_contactno" id="add_contactno">
              <div class="input-group">
                  <select class="form-control" name="dine_ids[]" id="dine_ids"  multiple data-placeholder="Please select dines">
                    @foreach($data as $key=>$value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                  </select>
                  @if($errors->first('dine_ids')) <p class="text-danger">{{ $errors->first('dine_ids') }}</p> @endif
                  
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Food Court</label>
            <div class="col-sm-10 add_contactno" id="add_contactno">
              <div class="input-group">
                  <select class="form-control" name="fc_outlets[]" id="fc_outlets"  multiple data-placeholder="Please select food court outlets">
                    @foreach($data as $key=>$value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                  </select>
                  @if($errors->first('fc_outlets')) <p class="text-danger">{{ $errors->first('fc_outlets') }}</p> @endif
                  
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Image (JPEG, PNG)</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="imagefile" required placeholder="Select image" required accept=".jpg,.jpeg,.png">
              @if($errors->first('imagefile')) <p class="text-danger">{{ $errors->first('imagefile') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Button Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter button name" name="button_name" required value="{{ old('button_name') }}">
              @if($errors->first('button_name')) <p class="text-danger">{{ $errors->first('button_name') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Unlimited</label>
            <div class="col-sm-10">
              <select class="form-control" name="unlimited" required>
                <option value="1">Yes</option>
                <option value="0" selected>No</option>
              </select>
              @if($errors->first('unlimited')) <p class="text-danger">{{ $errors->first('unlimited') }}</p> @endif
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
          <a class="btn btn-primary pull-left" href="admin/contest/">Back</a>
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