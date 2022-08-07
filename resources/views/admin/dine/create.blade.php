@extends('admin.layout.master')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Dine
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/dine/">Dine</a></li>
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
              <textarea id="description" class="form-control" required name="description" rows="5">{{ old('description') }}</textarea>
              @if($errors->first('description')) <p class="text-danger">{{ $errors->first('description') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Logo (JPEG, PNG)</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="logofile" required placeholder="Select logo" required accept=".jpg,.jpeg,.png">
              @if($errors->first('logofile')) <p class="text-danger">{{ $errors->first('logofile') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Floor</label>
            <div class="col-sm-10">
              <select class="form-control" name="floor" required>
                <option value="" disabled selected>--- Choose ---</option>
                <option  {{ old('floor')=="Basement" ? 'selected':'' }}>Basement</option>
                <option  {{ old('floor')=="Ground Floor" ? 'selected':'' }}>Ground Floor</option>
                <option  {{ old('floor')=="First Floor" ? 'selected':'' }}>First Floor</option>
                <option  {{ old('floor')=="Second Floor" ? 'selected':'' }}>Second Floor</option>
                <option  {{ old('floor')=="Third Floor" ? 'selected':'' }}>Third Floor</option>
                <option  {{ old('floor')=="Fourth Floor" ? 'selected':'' }}>Fourth Floor</option>
                <option  {{ old('floor')=="Fifth Floor" ? 'selected':'' }}>Fifth Floor</option>
                <option  {{ old('floor')=="Sixth Floor" ? 'selected':'' }}>Sixth Floor</option>
              </select>
              @if($errors->first('floor')) <p class="text-danger">{{ $errors->first('floor') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Type</label>
            <div class="col-sm-10">
              <select class="form-control" name="type_id" required>
                <option value="" disabled selected>--- Choose ---</option>
                @foreach($data as $value)
                    <option value="{{ $value->id }}" {{ old('type_id')==$value->id ? 'selected':'' }}>{{ $value->title }}</option>
                @endforeach
              </select>
              @if($errors->first('type_id')) <p class="text-danger">{{ $errors->first('type_id') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Category</label>
            <div class="col-sm-10">
              <select class="form-control" name="category_id[]" multiple data-placeholder="-- Choose --">
                @foreach($category as $value)
                    <option value="{{ $value->id }}" {{ in_array($value->id ,old('category_id',[])) ? 'selected':'' }}>{{ $value->title }}</option>
                @endforeach
              </select>
              @if($errors->first('category_id')) <p class="text-danger">{{ $errors->first('category_id') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Cuisine</label>
            <div class="col-sm-10">
              <select class="form-control" name="cuisine[]" multiple data-placeholder="-- Choose --" required>
                @foreach($cuisine as $value)
                    <option value="{{ $value->id }}" {{ in_array($value->id ,old('cuisine',[])) ? 'selected':'' }}>{{ $value->title }}</option>
                @endforeach
              </select>
              @if($errors->first('cuisine')) <p class="text-danger">{{ $errors->first('cuisine') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Menu Link</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter menu" name="menu" value="{{ old('menu') }}">
              @if($errors->first('menu')) <p class="text-danger">{{ $errors->first('menu') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Review Link</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter review" name="review" value="{{ old('review') }}">
              @if($errors->first('review')) <p class="text-danger">{{ $errors->first('review') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Location (JEPG, PNG)</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" placeholder="Enter location" name="locationfile" required accept=".jpg,.jpeg,.png">
              @if($errors->first('locationfile')) <p class="text-danger">{{ $errors->first('locationfile') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Store Timing</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter timing" name="timing" required value="{{ old('timing') }}">
              @if($errors->first('timing')) <p class="text-danger">{{ $errors->first('timing') }}</p> @endif
            </div>
          </div>

          {{-- <div class="form-group">
            <label class="control-label col-sm-2">Store Phone</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter store phone number" name="store_phone" required value="{{ old('store_phone') }}">
              @if($errors->first('store_phone')) <p class="text-danger">{{ $errors->first('store_phone') }}</p> @endif
            </div>
          </div> --}}
          <div class="form-group">
            <label class="control-label col-sm-2">Dine Phone</label>
            <div class="col-sm-10 add_contactno" id="add_contactno">
              <div class="input-group">
                  <span class="input-group-addon">
                    <input type="radio" required aria-label="..." class="phonePrimaryCheck" name="primaryPhone" value="0">
                  </span>
                  <input type="text" class="form-control" placeholder="Enter dine phone number" name="store_phones[]" required value="">
                  @if($errors->first('store_phones')) <p class="text-danger">{{ $errors->first('store_phones') }}</p> @endif
                   <span class="input-group-btn">
                    <button type="button" onclick="add_contactno(this)" class="btn btn-primary waves-effect"><i class="fa fa-plus" aria-hidden="true"></i></button>
                  </span>
              </div>
            </div>
          </div>


          <div class="form-group">
            <label class="control-label col-sm-2">Manager Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter manager name" name="manager" required value="{{ old('manager') }}">
              @if($errors->first('manager')) <p class="text-danger">{{ $errors->first('manager') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Manager Phone</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter manager phone number" name="manager_phone" required value="{{ old('manager_phone') }}">
              @if($errors->first('manager_phone')) <p class="text-danger">{{ $errors->first('manager_phone') }}</p> @endif
            </div>
          </div>

          {{-- <div class="form-group">
            <label class="control-label col-sm-2">Email</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter email" name="email" value="{{ old('email') }}">
              @if($errors->first('email')) <p class="text-danger">{{ $errors->first('email') }}</p> @endif
            </div>
          </div> --}}



          <div class="form-group">
            <label class="control-label col-sm-2">Dine Email</label>
            <div class="col-sm-10 add_contactemail" id="add_contactemail">
              <div class="input-group">
                  <span class="input-group-addon">
                    <input type="radio" required aria-label="..." class="emailPrimaryCheck" name="primaryEmail" value="0">
                  </span>
                  <input type="text" class="form-control" placeholder="Enter dine email" name="emails[]" required value="">
                  @if($errors->first('emails')) <p class="text-danger">{{ $errors->first('emails') }}</p> @endif
                   <span class="input-group-btn">
                    <button type="button" onclick="add_contactemail(this)" class="btn btn-primary waves-effect"><i class="fa fa-plus" aria-hidden="true"></i></button>
                  </span>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Website</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter website" name="website" value="{{ old('website') }}">
              @if($errors->first('website')) <p class="text-danger">{{ $errors->first('website') }}</p> @endif
            </div>
          </div>



          <p class="label-hr">SEO/Open Graph Content (optional)</p>

          <div class="form-group">
            <label class="control-label col-sm-2">Meta Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter Meta Title" name="meta_title" value="{{ old('meta_title') }}">
              @if($errors->first('meta_title')) <p class="text-danger">{{ $errors->first('meta_title') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Meta Description</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter Meta Description" name="meta_desc" value="{{ old('meta_desc') }}">
              @if($errors->first('meta_desc')) <p class="text-danger">{{ $errors->first('meta_desc') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Meta Keyword</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter Meta Keyword" name="meta_keyword" value="{{ old('meta_keyword') }}">
              @if($errors->first('meta_keyword')) <p class="text-danger">{{ $errors->first('meta_keyword') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Meta Image (JPG or PNG)</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="meta_imagefile" placeholder="Select Image" accept=".png,.jpeg,.jpg">
              @if($errors->first('meta_imagefile')) <p class="text-danger">{{ $errors->first('meta_imagefile') }}</p> @endif
            </div>
          </div>
          <p class="label-hr">Page Settings</p>
          <div class="form-group">
            <label class="control-label col-sm-2">Post Time</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter date time" name="post_time" value="{{ old('post_time') }}">
              @if($errors->first('post_time')) <p class="text-danger">{{ $errors->first('post_time') }}</p> @endif
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
          <a class="btn btn-primary pull-left" href="admin/dine/">Back</a>
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
    $('[name="post_time"]').datetimepicker({format: 'YYYY-MM-DD hh:mm A'});
  });

  $('[name="type_id"]').change(function(event) {
    $('[name="type"]').val($('[name="type_id"]>option:selected').data('type'));

    if($('[name="type_id"]>option:selected').data('type') == 'dine') $('#dd').show().find('input').prop('required',true)
    else  $('#dd').hide().find('input').prop('required',false)
  });



   function add_contactno(btn) {
  var index = $('#add_contactno>div').length;

  var input = $('<div class="input-group"><span class="input-group-addon"><input type="radio" required aria-label="..." class="phonePrimaryCheck" name="primaryPhone" value="'+index+'"></span><input type="text" class="form-control" placeholder="Enter dine phone number" name="store_phones[]" required value=""><span class="input-group-btn"><button type="button" onclick="$(this).closest(`.input-group`).remove()" class="btn btn-danger waves-effect"><i class="fa fa-close" aria-hidden="true"></i></button></span></div>');
  $('#add_contactno').append(input);

}


 function add_contactemail(btn) {
  var index = $('#add_contactemail>div').length;

  var input = $('<div class="input-group"><span class="input-group-addon"><input type="radio" required aria-label="..." class="emailPrimaryCheck" name="primaryEmail" value="'+index+'"></span><input type="text" class="form-control" placeholder="Enter dine email" name="emails[]" required value=""><span class="input-group-btn"><button type="button" onclick="$(this).closest(`.input-group`).remove()" class="btn btn-danger waves-effect"><i class="fa fa-close" aria-hidden="true"></i></button></span></div>');

  $('#add_contactemail').append(input);

}

$(document).on('change', '.phonePrimaryCheck', function(event) {
  $('.phonePrimaryCheck').prop('checked', false);
  $(this).prop('checked', true);
});


$(document).on('change', '.emailPrimaryCheck', function(event) {
  $('.emailPrimaryCheck').prop('checked', false);
  $(this).prop('checked', true);
});
</script>


@endsection