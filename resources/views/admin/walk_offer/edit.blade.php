@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Offer
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/walk_offer/">Walk and Win Offers</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="box">
      <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box-body">
          <div class="row">
              <div class="col-sm-2">
                <p><b>Image:</b></p>
                @if($data->image)
                <img src="{{ asset('storage/walk_offer/actual/'.$data->image) }}" alt="..." class="img-responsive">
                @else
                No image found.
                @endif
              </div>
              <div class="col-sm-10">

                <div class="form-group">
                  <label class="control-label col-sm-2">Store</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="store_id" required>
                      <option value="" disabled selected>--- Choose ---</option>
                      @foreach($store as $value)
                          <option  value="{{ $value->id }}" {{ $data->store_id==$value->id ? 'selected':'' }}>{{ $value->name }}</option>
                      @endforeach
                    </select>
                    @if($errors->first('store_id')) <p class="text-danger">{{ $errors->first('store_id') }}</p> @endif
                  </div>
                </div>


                <div class="form-group">
                  <label class="control-label col-sm-2">Offer</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" placeholder="Enter offer" name="offer" required>{{ $data->offer }}</textarea>
                    @if($errors->first('offer')) <p class="text-danger">{{ $errors->first('offer') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Image (JPG) (2:1)<br><small>(Max 512kb)</small> </label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" name="imagefile" placeholder="Select Image" accept=".jpeg,.jpg">
                    @if($errors->first('imagefile')) <p class="text-danger">{{ $errors->first('imagefile') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Threshold</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="threshold" required>
                      @foreach($level as $key=>$value)
                      <option value="{{ $value->id }}" {{ $data->threshold == $value->id ?'selected':'' }}>{{ $value->type }} ({{ $value->threshold }} Steps)</option>
                      @endforeach
                    </select>
                    @if($errors->first('threshold')) <p class="text-danger">{{ $errors->first('threshold') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Start Date</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" autocomplete="off" placeholder="Enter start date" name="start_date" value="{{ $data->start_date }}">
                    @if($errors->first('start_date')) <p class="text-danger">{{ $errors->first('start_date') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Redeem within</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <input type="number" min="1" max="30" class="form-control" required placeholder="Enter day" name="redeem_within" value="{{ $data->redeem_within }}">
                      <span class="input-group-addon">Days</span>
                    </div>
                    @if($errors->first('redeem_within')) <p class="text-danger">{{ $errors->first('redeem_within') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Redeem Code</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <input type="text" maxlength="10" class="form-control" required placeholder="Enter redeem code" name="code" value="{{ $data->code }}">
                      <span class="input-group-btn"><button class="btn btn-primary" onclick="genCode();" type="button">Generate Code</button></span>
                    </div>
                    @if($errors->first('code')) <p class="text-danger">{{ $errors->first('code') }}</p> @endif
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
            </div>

            <div class="col-sm-12">
              <div class="box-footer text-right">
                <a class="btn btn-primary pull-left" href="admin/walk_offer/">Back</a>
                <button type="submit" class="btn btn-success">Save</button>
              </div>
            </div>
          </div>
      </form>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function() {
    $('[name="start_date"]').datepicker({ format: 'yyyy-mm-dd'});
  });

  function genCode() {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < 7; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    $('[name="code"]').val(result);
  }
</script>

@endsection