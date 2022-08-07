@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    View Contest Participants Transaction
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/contest_participants_transaction/">Contest Participants Transaction</a></li>>
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
                  <label class="control-label col-sm-2">User</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ get_anydata('user',$data->participantDetails->user_id,'name') }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Contest</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ get_anydata('contest',$data->participantDetails->contest_id,'name')}}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Dine</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->dineDetails->name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Threshold</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->thresholdDetails->percentage }} %">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Unique Code</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->unique_code }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Transaction Amount</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->trans_amount }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Transaction Date</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->trans_date }}">
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="box-footer text-right">
                  <a class="btn btn-primary pull-left waves-effect" href="admin/contest_participants_transaction/">Back</a>
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