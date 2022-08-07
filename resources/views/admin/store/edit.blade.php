@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Store
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/store/">Stores</a></li>
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
                <p><b>Logo:</b></p>
                @if($data->logo)
                <img src="{{ asset('storage/store/actual/'.$data->logo) }}" alt="..." class="img-responsive">
                @else
                No image found.
                @endif

                <hr>
                <p><b>Location:</b></p>
                @if($data->location)
                <img src="{{ asset('storage/store/actual/'.$data->location) }}" alt="..." class="img-responsive">
                @else
                No image found.
                @endif

                <hr>
                <p><b>Meta Image:</b></p>
                @if($data->meta_image)
                <img src="{{ asset('storage/link_data/'.$data->meta_image) }}" alt="..." class="img-responsive">
                @else
                No image found.
                @endif
              </div>
              <div class="col-sm-10">

                <div class="form-group">
                  <label class="control-label col-sm-2">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter name" name="name" required value="{{ $data->name }}">
                    @if($errors->first('name')) <p class="text-danger">{{ $errors->first('name') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Description</label>
                  <div class="col-sm-10">
                    <textarea id="description" class="form-control" required name="description" rows="5">{{ $data->description }}</textarea>
                    @if($errors->first('description')) <p class="text-danger">{{ $errors->first('description') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Logo (JPEG, PNG)</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" name="logofile" placeholder="Select logo" accept=".jpg,.jpeg,.png">
                    @if($errors->first('logofile')) <p class="text-danger">{{ $errors->first('logofile') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Floor</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="floor" required>
                      <option value="" disabled selected>--- Choose ---</option>
                      <option  {{ $data->floor=="Basement" ? 'selected':'' }}>Basement</option>
                      <option  {{ $data->floor=="Ground Floor" ? 'selected':'' }}>Ground Floor</option>
                      <option  {{ $data->floor=="First Floor" ? 'selected':'' }}>First Floor</option>
                      <option  {{ $data->floor=="Second Floor" ? 'selected':'' }}>Second Floor</option>
                      <option  {{ $data->floor=="Third Floor" ? 'selected':'' }}>Third Floor</option>
                      <option  {{ $data->floor=="Fourth Floor" ? 'selected':'' }}>Fourth Floor</option>
                      <option  {{ $data->floor=="Fifth Floor" ? 'selected':'' }}>Fifth Floor</option>
                    </select>
                    @if($errors->first('floor')) <p class="text-danger">{{ $errors->first('floor') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Type</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="type_id" required>
                      <option value="" disabled selected>--- Choose ---</option>
                      @foreach($type as $value)
                          <option value="{{ $value->id }}" {{ $data->type_id==$value->id ? 'selected':'' }}>{{ $value->title }}</option>
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
                          <option value="{{ $value->id }}" {{ in_array($value->id ,explode(',',$data->category_id)) ? 'selected':'' }}>{{ $value->title }}</option>
                      @endforeach
                    </select>
                    @if($errors->first('category_id')) <p class="text-danger">{{ $errors->first('category_id') }}</p> @endif
                  </div>
                </div>




                <div class="form-group">
                  <label class="control-label col-sm-2">Location (JEPG, PNG)</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" placeholder="Enter location" name="locationfile" accept=".jpg,.jpeg,.png">
                    @if($errors->first('locationfile')) <p class="text-danger">{{ $errors->first('locationfile') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Store Timing</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter timing" name="timing" required value="{{ $data->timing }}">
                    @if($errors->first('timing')) <p class="text-danger">{{ $errors->first('timing') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Old Phone</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter store phone number" value="{{ $data->store_phone }}" readonly>
                  </div>
                </div>

                
                <div class="form-group">
                  <label class="control-label col-sm-2">Store Phone</label>
                  <div class="col-sm-10 add_contactno" id="add_contactno">
                    @if($data->contactno->count()>0)
                      @foreach($data->contactno as $key=>$value)
                      <div class="input-group">
                        <span class="input-group-addon">
                          <input type="radio" required aria-label="..." class="phonePrimaryCheck" name="primaryPhone" value="{{$key}}" {{$value->primary==1?'checked':''}}>
                        </span>
                          <input type="text" class="form-control" placeholder="Enter store phone number" name="store_phones[]" required value="{{$value->phone}}">
                          @if($errors->first('store_phones')) <p class="text-danger">{{ $errors->first('store_phones') }}</p> @endif
                          <span class="input-group-btn">
                             @if($key==0)
                              <button type="button" onclick="add_contactno(this)" class="btn btn-primary waves-effect"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            @else
                              <button type="button" onclick="$(this).closest(`.input-group`).remove()" class="btn btn-danger waves-effect"><i class="fa fa-close" aria-hidden="true"></i></button>
                            @endif
                          </span>
                      </div>
                      @endforeach
                    @else
                      <div class="input-group">
                        <span class="input-group-addon">
                          <input type="radio" required aria-label="..." class="phonePrimaryCheck" name="primaryPhone" value="0">
                        </span>
                        <input type="text" class="form-control" placeholder="Enter store phone number" name="store_phones[]" required value="">
                        @if($errors->first('store_phones')) <p class="text-danger">{{ $errors->first('store_phones') }}</p> @endif
                         <span class="input-group-btn">
                          <button type="button" onclick="add_contactno(this)" class="btn btn-primary waves-effect"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </span>
                    </div>
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Manager Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter manager name" name="manager" required value="{{ $data->manager }}">
                    @if($errors->first('manager')) <p class="text-danger">{{ $errors->first('manager') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Manager Phone</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter manager phone number" name="manager_phone" required value="{{ $data->manager_phone }}">
                    @if($errors->first('manager_phone')) <p class="text-danger">{{ $errors->first('manager_phone') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">OLD Email</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter email" value="{{ $data->email }}" readonly>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Store Email</label>
                  <div class="col-sm-10 add_contactemail" id="add_contactemail">
                    @if($data->contactemail->count()>0)
                      @foreach($data->contactemail as $key=>$value)
                      <div class="input-group">
                        <span class="input-group-addon">
                          <input type="radio" required aria-label="..." class="emailPrimaryCheck" name="primaryEmail" value="{{$key}}" {{$value->primary==1?'checked':''}}>
                        </span>
                          <input type="text" class="form-control" placeholder="Enter store email" name="emails[]" required value="{{$value->email}}">
                          @if($errors->first('emails')) <p class="text-danger">{{ $errors->first('emails') }}</p> @endif
                          <span class="input-group-btn">
                             @if($key==0)
                              <button type="button" onclick="add_contactemail(this)" class="btn btn-primary waves-effect"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            @else
                              <button type="button" onclick="$(this).closest(`.input-group`).remove()" class="btn btn-danger waves-effect"><i class="fa fa-close" aria-hidden="true"></i></button>
                            @endif
                          </span>
                      </div>
                      @endforeach
                    @else
                      <div class="input-group">
                        <span class="input-group-addon">
                          <input type="radio" required aria-label="..." class="emailPrimaryCheck" name="primaryEmail" value="0">
                        </span>
                        <input type="text" class="form-control" placeholder="Enter store email" name="emails[]" required value="">
                        @if($errors->first('emails')) <p class="text-danger">{{ $errors->first('emails') }}</p> @endif
                         <span class="input-group-btn">
                          <button type="button" onclick="add_contactno(this)" class="btn btn-primary waves-effect"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </span>
                    </div>
                    @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Website</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter website" name="website" value="{{ $data->website }}">
                    @if($errors->first('website')) <p class="text-danger">{{ $errors->first('website') }}</p> @endif
                  </div>
                </div>

              </div>


              <div class="col-sm-12">
                <p class="label-hr">SEO/Open Graph Content (optional)</p>
              </div>

              <div class="col-sm-10 col-sm-offset-2">

                <div class="form-group">
                  <label class="control-label col-sm-2">Meta Title</label>
                  <div class="col-sm-10">
                    <div class="form-line">
                      <input type="text" class="form-control" placeholder="Enter Meta Title" name="meta_title" value="{{ $data->meta_title }}">
                    </div>
                    @if($errors->first('meta_title')) <p class="text-danger">{{ $errors->first('meta_title') }}</p> @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Meta Description</label>
                  <div class="col-sm-10">
                    <div class="form-line">
                      <input type="text" class="form-control" placeholder="Enter Meta Description" name="meta_desc" value="{{ $data->meta_desc }}">
                    </div>
                    @if($errors->first('meta_desc')) <p class="text-danger">{{ $errors->first('meta_desc') }}</p> @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Meta Keyword</label>
                  <div class="col-sm-10">
                    <div class="form-line">
                      <input type="text" class="form-control" placeholder="Enter Meta Keyword" name="meta_keyword" value="{{ $data->meta_keyword }}">
                    </div>
                    @if($errors->first('meta_keyword')) <p class="text-danger">{{ $errors->first('meta_keyword') }}</p> @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Meta Image<br><small>(JPG or PNG)</small></label>
                  <div class="col-sm-10">
                    <div class="form-line">
                      <input type="file" class="form-control" name="meta_imagefile" placeholder="Select Image" accept=".png,.jpeg,.jpg">
                    </div>
                    @if($errors->first('meta_imagefile')) <p class="text-danger">{{ $errors->first('meta_imagefile') }}</p> @endif
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <p class="label-hr">Page Setting</p>
              </div>

              <div class="col-sm-10 col-sm-offset-2">
                <div class="form-group">
                  <label class="control-label col-sm-2">Post Time</label>
                  <div class="col-sm-10">
                    <div class="form-line">
                      <input type="text" class="form-control" required placeholder="Enter date time" name="post_time" value="{{ $data->post_time }}">
                    </div>
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
                  <a class="btn btn-primary pull-left waves-effect" href="admin/store/">Back</a>
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
    $('[name="post_time"]').datetimepicker({format: 'YYYY-MM-DD hh:mm A'});
  });


function add_contactno(btn) {
  var index = $('#add_contactno>div').length;

  var input = $('<div class="input-group"><span class="input-group-addon"><input type="radio" required aria-label="..." class="phonePrimaryCheck" name="primaryPhone" value="'+(index)+'"></span><input type="text" class="form-control" placeholder="Enter store phone number" name="store_phones[]" required value=""><span class="input-group-btn"><button type="button" onclick="$(this).closest(`.input-group`).remove()" class="btn btn-danger waves-effect"><i class="fa fa-close" aria-hidden="true"></i></button></span></div>');
  $('#add_contactno').append(input);

}


function add_contactemail(btn) {
  var index = $('#add_contactemail>div').length;

  var input = $('<div class="input-group"><span class="input-group-addon"><input type="radio" required aria-label="..." class="emailPrimaryCheck" name="primaryEmail" value="'+(index)+'"></span><input type="text" class="form-control" placeholder="Enter store email" name="emails[]" required value=""><span class="input-group-btn"><button type="button" onclick="$(this).closest(`.input-group`).remove()" class="btn btn-danger waves-effect"><i class="fa fa-close" aria-hidden="true"></i></button></span></div>');

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