@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    View Details
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/qcard_transaction/">Qcard Transaction Details</a></li>>
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
                  <label class="control-label col-sm-2">User name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ get_anydata('user',$data->user_id,'name') }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Store name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ get_anydata('store',$data->store_id,'name') }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Type</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->type }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Amount</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->amount }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Balance</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->balance }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Source</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->source }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Bank Transaction id</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->bank_trans_id }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Created</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->created_at->format('M d, Y - h:i a') }}">
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="box-footer text-right">
                  <a class="btn btn-primary pull-left waves-effect" href="admin/qcard_transaction/">Back</a>
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