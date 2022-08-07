@extends('admin.layout.master')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Type
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/admin_type/">Admin Type</a></li>
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
              <input type="text" class="form-control" placeholder="Enter title" name="title" required value="{{ old('title') }}">
              @if($errors->first('title')) <p class="text-danger">{{ $errors->first('title') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Modules</label>
            <div class="col-sm-10 " style="max-height: 300px;overflow: auto;">
              <table class="table table-condensed table-bordered table-striped">
                @foreach($data as $key=>$value)
                  @if(count_rows('admin_module',[['parent_id',$value->id]]) == 0)
                      <tr>
                        <td>
                          <input type="checkbox" name="module[]" id="module{{ $key }}" value="{{ $value->id }}" class="filled-in">
                          <label class="form-label m-b-0" for="module{{ $key }}">{{ $value->module }}</label>
                        </td>
                        <td style="pointer-events: none;opacity: .5">

                          @php
                          $access=explode(',',$value->access_type);
                          @endphp

                          @foreach ($access as $k => $val)
                          <span>
                            <input type="checkbox" name="access_type[]" id="module{{ $key }}_{{ $k }}" value="{{ $value->id }}_{{ $val }}" class="filled-in">
                            <label class="form-label m-b-0 text-uppercase" for="module{{ $key }}_{{ $k }}">{{ $val }}</label>
                          </span><i class="fa fa-fw"></i>
                          @endforeach
                        </td>
                      </tr>
                  @endif
                @endforeach
              </table>
              @if($errors->first('module')) <p class="text-danger">{{ $errors->first('module') }}</p> @endif
              @if($errors->first('access_type')) <p class="text-danger">{{ $errors->first('access_type') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Active</label>
            <div class="col-sm-10">
              <select class="form-control" name="active" required>
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
              </select>
              @if($errors->first('active')) <p class="text-danger">{{ $errors->first('active') }}</p> @endif
            </div>
          </div>
        </div>
        <div class="box-footer text-right">
          <a class="btn btn-primary pull-left" href="admin/admin_type/">Back</a>
          <button type="submit" class="btn btn-success">Save</button>
        </div>

      </form>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $('[name="module[]"]').change(function(event) {
    $td = $(this).closest('tr').find('td')[1];
    if(this.checked) $($td).css({'pointer-events':'all', 'opacity':1});
    else $($td).css({'pointer-events':'none', 'opacity':.5});

    $($td).find('input').each(function(index, el) {
      this.checked = false;
      //$(this).trigger('change')
    });
  });
</script>

@endsection