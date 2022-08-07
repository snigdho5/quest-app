@extends('admin.layout.master')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Banner of '{{ get_anydata('qreview',$q_id, 'title') }}'
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/qreview">Stores</a></li>
      <li><a href="admin/qreview/{{ $q_id }}/gallery">Gallery</a></li>
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
            <label class="control-label col-sm-2">Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required placeholder="Enter title" name="title" value="{{ old('title') }}">
              @if($errors->first('title')) <p class="text-danger">{{ $errors->first('title') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Website Image (JPG)</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="imagefile" required placeholder="Select Image" accept=".jpeg,.jpg">
              @if($errors->first('imagefile')) <p class="text-danger">{{ $errors->first('imagefile') }}</p> @endif
            </div>
          </div>

          {{-- <div class="form-group">
            <label class="control-label col-sm-2">App Image (JPG)</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="aimagefile" required placeholder="Select Image" accept=".jpeg,.jpg">
              @if($errors->first('aimagefile')) <p class="text-danger">{{ $errors->first('aimagefile') }}</p> @endif
            </div>
          </div>
 --}}
          {{-- <div class="form-group">
            <label class="control-label col-sm-2">Featured</label>
            <div class="col-sm-10">
              <select class="form-control" name="featured" required>
                <option value="1">Yes</option>
                <option value="0" selected>No</option>
              </select>
              @if($errors->first('featured')) <p class="text-danger">{{ $errors->first('featured') }}</p> @endif
            </div>
          </div>
 --}}
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
          <a class="btn btn-primary pull-left" href="admin/qreview/{{ $q_id }}/gallery">Back</a>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection