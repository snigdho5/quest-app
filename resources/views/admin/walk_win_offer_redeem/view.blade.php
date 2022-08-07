@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    View Query
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/query/">Quest Query</a></li>>
      <li class="active">View</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">

    <div class="box">
      <div class="box-body">
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="row">

              <div class="col-sm-12">

                <div class="form-group">
                  <label class="control-label col-sm-2">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Contact</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->contact }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Query</label>
                  <div class="col-sm-10">
                    <textarea id="code" class="form-control" rows="5" readonly>{{ $data->query }}</textarea>
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="box-footer text-right">
                  <a class="btn btn-primary pull-left waves-effect" href="admin/query/">Back</a>
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



@endsection