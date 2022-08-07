@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    View Store/Dine Review
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/store_review/">Store/Dine Review</a></li>>
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
                  <label class="control-label col-sm-2">User Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ get_anydata('user',$data->user_id,'name') }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Store/Dine</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ get_anydata('store',$data->store_id,'name') }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Rating</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->rate }}">
                  </div>
                </div>
                <?php if($data->message):?>
                <div class="form-group">
                  <label class="control-label col-sm-2">Message</label>
                  <div class="col-sm-10">
                    <textarea id="code" class="form-control" rows="5" readonly>{{ $data->message }}</textarea>
                  </div>
                </div>
                <?php endif; ?>
                <div class="form-group">
                  <label class="control-label col-sm-2">Approve</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->approve=='0'?'No':'Yes' }}">
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="box-footer text-right">
                  <a class="btn btn-primary pull-left waves-effect" href="admin/store_review/">Back</a>
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