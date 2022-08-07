@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Module
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/navigation/">Website Navigation</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="box">
      <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box-body">
          <div class="form-group">
            <label class="control-label col-sm-2">Menu</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter menu name" name="menu" required value="{{ $data->menu }}">
              @if($errors->first('menu')) <p class="text-danger">{{ $errors->first('menu') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Parent Menu<br><small>(optional)</small></label>
            <div class="col-sm-10">
              <select class="form-control show-tick" name="parent_id">
                <option value="0" selected>--- No Parent ---</option>
                @foreach($allData as $value)
                  @if($value->parent_id==0)
                    <option value="{{ $value->id }}" {{ $data->parent_id==$value->id ? 'selected':'' }}>{{ $value->menu }}</option>
                  @endif
                @endforeach
              </select>
              @if($errors->first('parent_id')) <p class="text-danger">{{ $errors->first('parent_id') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Link</label>
            <div class="col-sm-10">

                <div class="input-group">
                  <span class="input-group-addon">{{ url('/') }}/</span>
                  <input type="text" required class="form-control" placeholder="Enter link (# for parent menu)" name="link" value="{{ $data->link }}">
                </div>
              @if($errors->first('link')) <p class="text-danger">{{ $errors->first('link') }}</p> @endif
            </div>
          </div>



          <div class="form-group">
            <label class="control-label col-sm-2">Active</label>
            <div class="col-sm-10">
              <select class="form-control" name="active" required>
                <option value="1" {{ $data->active == '1'?'selected':'' }}>Yes</option>
                <option value="0" {{ $data->active == '0'?'selected':'' }}>No</option>
              </select>
              @if($errors->first('active')) <p class="text-danger">{{ $errors->first('active') }}</p> @endif
            </div>
          </div>
        </div>
        <div class="box-footer text-right">
          <a class="btn btn-primary pull-left" href="admin/navigation/">Back</a>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function() {
    $('[name="icon"]').select2({
      templateResult: setIcon,
      templateSelection: setIcon
    });
  });
  function setIcon (option) {
    if (!option.id) { return option.text; }
    var $option = $('<span><i class="fa fa-'+option.text+'" style="width:30px"></i> '+option.text+'</span>');
    return $option;
  }
</script>


@endsection