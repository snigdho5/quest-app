@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Post
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/blog/">Blog</a></li>
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
                <p><b>Header Image:</b></p>
                @if($data->image)
                <img src="{{ asset('storage/blog/actual/'.$data->image) }}" alt="..." class="img-responsive">
                @else
                No image found.
                @endif

                <hr>
                <p><b>Thumb Image:</b></p>
                @if($data->sq_image)
                <img src="{{ asset('storage/blog/thumb/'.$data->sq_image) }}" alt="..." class="img-responsive">
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
                  <label class="control-label col-sm-2">Category</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="category_id" required>
                      <option value="" disabled selected>--- Choose ---</option>
                      @foreach($category as $value)
                          <option value="{{ $value->id }}" {{ $data->category_id==$value->id ? 'selected':'' }}>{{ $value->title }}</option>
                      @endforeach
                    </select>
                    @if($errors->first('category_id')) <p class="text-danger">{{ $errors->first('category_id') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter title" name="title" required value="{{ $data->title }}">
                    @if($errors->first('title')) <p class="text-danger">{{ $errors->first('title') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Seo URL</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <span class="input-group-addon">{{ url('/blog/') }}/</span>
                      <input type="hidden" name="old_slug" required value="{{ $data->slug }}">
                      <input type="text" class="form-control" placeholder="Enter URL" name="slug" readonly required value="{{ $data->slug }}" pattern="[0-9A-Za-z-_.]*" title="Allowed charaters A-Z, a-z, 0-9, '-', '_', '.'">
                      <span class="input-group-btn"><button onclick="readonly(this)" type="button" class="btn btn-default"><i class="fa fa-fw fa-pencil"></i></button></span>
                    </div>
                    @if($errors->first('slug')) <p class="text-danger">{{ $errors->first('slug') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Body Content</label>
                  <div class="col-sm-10">
                    <textarea id="content" class="form-control" name="content" rows="10">{{ $data->content }}</textarea>
                    @if($errors->first('content')) <p class="text-danger">{{ $errors->first('content') }}</p> @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Header Image (JPEG, PNG)</label>
                  <div class="col-sm-10">
                    <div class="form-line">
                      <input type="file" class="form-control" name="imagefile" placeholder="Select Image" accept=".jpg,.jpeg,.png">
                    </div>
                    @if($errors->first('imagefile')) <p class="text-danger">{{ $errors->first('imagefile') }}</p> @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Thumb Image (JPEG, PNG)</label>
                  <div class="col-sm-10">
                    <div class="form-line">
                      <input type="file" class="form-control" name="sq_imagefile" placeholder="Select Image" accept=".jpg,.jpeg,.png">
                    </div>
                    @if($errors->first('sq_imagefile')) <p class="text-danger">{{ $errors->first('sq_imagefile') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Link Stores (optional)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="store_id[]" multiple data-placeholder="-- Choose --">
                      @foreach($store as $value)
                        <option value="{{ $value->id }}" {{ in_array($value->id,explode(',',$data->store_id)) ? 'selected':'' }}>{{ $value->name }}</option>
                      @endforeach
                    </select>
                    @if($errors->first('store_id')) <p class="text-danger">{{ $errors->first('store_id') }}</p> @endif
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
                  <a class="btn btn-primary pull-left waves-effect" href="admin/blog/">Back</a>
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
<script src="bower_components/ckfinder/ckfinder.js"></script>

<script>
  $(document).ready(function() {
    var editor = CKEDITOR.replace('content');
    CKFinder.setupCKEditor( editor );
    $('[name="post_time"]').datetimepicker({format: 'YYYY-MM-DD hh:mm A'});
  });


  var r = true,t='';

  $('[name="title"]').keyup(function(event) {
    $('[name="slug"]').val($(this).val().toString()
    .trim()
    .toLowerCase()
    .replace(/\s+/g, "-")
    .replace(/[^\w\-]+/g, "")
    .replace(/\-\-+/g, "-")
    .replace(/^-+/, "")
    .replace(/-+$/, ""));

    clearTimeout(t);
    t = setTimeout(function(){
      checkSlug();
    },2500);
  });

  $('[name="slug"]').keyup(function(event) {
     clearTimeout(t);
      t = setTimeout(function(){
        checkSlug();
      },2500);
   });


  function checkSlug(){
    $.ajax({
      url: '{{ url("/admin") }}/ajax/checkblogSlug',
      type: 'POST',
      data: {slug: $('[name="slug"]').val(),id:"{{ $data->id }}"},
      success: function(data){
        $('[name="slug"]').val(data.trim());
      }
    });
  }

  function readonly(btn){
    if (r) {
      $(btn).find('i').toggleClass('fa-close fa-pencil');
      $(btn).closest('.input-group').find('input').prop('readonly',false);
      $(btn).closest('.form-line').removeClass('disabled')
      r = false;
    }else{
      $(btn).find('i').toggleClass('fa-close fa-pencil');
      $(btn).closest('.input-group').find('input').prop('readonly',true);
      $(btn).closest('.form-line').addClass('disabled')
      r=true;
    }
  }

</script>



@endsection