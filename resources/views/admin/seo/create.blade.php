@extends('admin.layout.master')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New SEO Data
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/link_data/">SEO & Conversion Code</a></li>
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
            <label class="control-label col-sm-2">Link</label>
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-addon">{{ url('/') }}/</span>
                <input type="text" class="form-control" placeholder="Enter link" name="link" required value="{{ old('link') }}">
              </div>
              @if($errors->first('link')) <p class="text-danger">{{ $errors->first('link') }}</p> @endif
            </div>
          </div>



          <div class="form-group">
            <label class="control-label col-sm-2">Meta Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required placeholder="Enter Meta Title" name="meta_title" value="{{ old('meta_title') }}">
              @if($errors->first('meta_title')) <p class="text-danger">{{ $errors->first('meta_title') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Meta Description</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required placeholder="Enter Meta Description" name="meta_desc" value="{{ old('meta_desc') }}">
              @if($errors->first('meta_desc')) <p class="text-danger">{{ $errors->first('meta_desc') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Meta Keyword</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required placeholder="Enter Meta Keyword" name="meta_keyword" value="{{ old('meta_keyword') }}">
              @if($errors->first('meta_keyword')) <p class="text-danger">{{ $errors->first('meta_keyword') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Meta Image (JPG or PNG) (optional)</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="meta_imagefile" placeholder="Select Image" accept=".png,.jpeg,.jpg">
              @if($errors->first('meta_imagefile')) <p class="text-danger">{{ $errors->first('meta_imagefile') }}</p> @endif
            </div>
          </div>


          <div class="form-group">
            <label class="control-label col-sm-2">Conversion Code (optional)</label>
            <div class="col-sm-10">
              <textarea id="code" class="form-control" name="code" rows="5">{{ old('code') }}</textarea>
              @if($errors->first('code')) <p class="text-danger">{{ $errors->first('code') }}</p> @endif
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
          <a class="btn btn-primary pull-left" href="admin/link_data/">Back</a>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection