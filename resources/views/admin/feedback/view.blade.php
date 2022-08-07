@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    View Feedback/Complain
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/feedback/">Feedback</a></li>>
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
                    <input type="text" class="form-control" readonly value="{{($data->user_id!=0)?get_anydata('user',$data->user_id,'name'):$data->name }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">User Email</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{($data->user_id!=0)?get_anydata('user',$data->user_id,'email'):$data->email }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">User Phone</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{($data->user_id!=0)?get_anydata('user',$data->user_id,'phone'):$data->mobile }}">
                  </div>
                </div>
                

                <div class="form-group">
                  <label class="control-label col-sm-2">Store/Dine</label>
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
                  <label class="control-label col-sm-2">For</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->for }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Floor</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->floor }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Reason</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="{{ $data->reason }}">
                  </div>
                </div>
                <?php if($data->feedback):?>
                <div class="form-group">
                  <label class="control-label col-sm-2">Feedback</label>
                  <div class="col-sm-10">
                    <textarea id="code" class="form-control" rows="5" readonly>{{ $data->feedback }}</textarea>
                  </div>
                </div>
                <?php endif; ?>
                
              </div>

              <div class="col-sm-12">
                <div class="box-footer text-right">
                  <a class="btn btn-primary pull-left waves-effect" href="admin/feedback/">Back</a>
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