@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Module
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/admin_module/">Admin Module</a></li>
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
            <label class="control-label col-sm-2">Module</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter module name" name="module" required value="{{ old('module') }}">
              @if($errors->first('module')) <p class="text-danger">{{ $errors->first('module') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Parent Module<br><small>(optional)</small></label>
            <div class="col-sm-10">
              <select class="form-control show-tick" name="parent_id">
                <option value="0" selected>--- No Parent ---</option>
                @foreach($data as $value)
                  @if($value->parent_id==0)
                    <option value="{{ $value->id }}" {{ old('parent_id')==$value->id ? 'selected':'' }}>{{ $value->module }}</option>
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
                  <span class="input-group-addon">{{ url('/') }}/admin/</span>
                  <input type="text" required class="form-control" placeholder="Enter link (# for parent menu)" name="link" value="{{ old('link') }}">
                </div>
              @if($errors->first('link')) <p class="text-danger">{{ $errors->first('link') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Access Type</label>
            <div class="col-sm-10">
              <select class="form-control show-tick" name="access_type[]" multiple data-placeholder="--Please Select--">
                <option value="add">Add</option>
                <option value="edit">Edit</option>
                <option value="delete">Delete</option>
                <option value="status">Status Change</option>
                <option value="order">Ordering</option>
                <option value="view">View</option>
                <option value="download">Download</option>
                <option value="print">Print</option>
                <option value="trigger">Trigger</option>
              </select>
              @if($errors->first('access_type')) <p class="text-danger">{{ $errors->first('access_type') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Icon<br><small>(optional)</small></label>
            <div class="col-sm-10">
              <select class="form-control show-tick" name="icon" data-live-search="true">
                <option value="" selected>--- No Icon ---</option>
                @php
                $iconFile = File::get('bower_components/font-awesome/css/font-awesome.min.css');
                preg_match_all("/[.]fa-[^:]*:/", $iconFile, $iconFile, PREG_SET_ORDER);
                $i=1;
                @endphp

                @foreach($iconFile as $icon)
                  @if($i>32)
                    @php $icon = str_replace('.fa-','',str_replace(':', '', $icon[0])); @endphp
                    <option value="{{ $icon }}" {{ old('icon')==$icon ? 'selected':'' }}>{{ $icon }}</option>
                  @endif
                  @php $i++; @endphp
                @endforeach
              </select>
              @if($errors->first('icon')) <p class="text-danger">{{ $errors->first('icon') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Show on Nagivation</label>
            <div class="col-sm-10">
              <select class="form-control" name="show_menu" required>
                <option value="1" {{ old('show_menu','1') == '1'?'selected':'' }}>Yes</option>
                <option value="0" {{ old('show_menu') == '0'?'selected':'' }}>No</option>
              </select>
              @if($errors->first('show_menu')) <p class="text-danger">{{ $errors->first('show_menu') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Active</label>
            <div class="col-sm-10">
              <select class="form-control" name="active" required>
                <option value="1" {{ old('active','1') == '1'?'selected':'' }}>Yes</option>
                <option value="0" {{ old('active') == '0'?'selected':'' }}>No</option>
              </select>
              @if($errors->first('active')) <p class="text-danger">{{ $errors->first('active') }}</p> @endif
            </div>
          </div>
        </div>
        <div class="box-footer text-right">
          <a class="btn btn-primary pull-left" href="admin/admin_module/">Back</a>
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