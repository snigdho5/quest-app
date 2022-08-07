@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Contest
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/contest/">Contest</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">

    <div class="box">
      <div class="box-body">
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
            <div class="row">
              <div class="col-sm-2">
                <p><b>Image:</b></p>
                @if($data->image)
                <img src="{{ asset('storage/contest/actual/'.$data->image) }}" alt="..." class="img-responsive">
                @else
                No image found.
                @endif
              </div>
              <div class="col-sm-10">

                <div class="form-group">
                  <label class="control-label col-sm-2">Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter name" value="{{ $data->name }}" name="name" required >
                    @if($errors->first('name')) <p class="text-danger">{{ $errors->first('name') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Description</label>
                  <div class="col-sm-10">
                    <textarea id="description" class="form-control" required name="content" rows="5">{{ $data->content }}</textarea>
                    @if($errors->first('content')) <p class="text-danger">{{ $errors->first('content') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Form Date</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter form date" name="form_date"
                    value="{{ $data->form_date }}">
                    @if($errors->first('form_date')) <p class="text-danger">{{ $errors->first('form_date') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">To Date</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter to date" name="to_date" value="{{ $data->to_date }}">
                    @if($errors->first('to_date')) <p class="text-danger">{{ $errors->first('to_date') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Terms</label>
                  <div class="col-sm-10">
                    <textarea id="terms" class="form-control" required name="terms" rows="5">{{ $data->terms }}</textarea>
                    @if($errors->first('terms')) <p class="text-danger">{{ $errors->first('terms') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Image (JPEG, PNG)</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" name="imagefile" placeholder="Select image" accept=".jpg,.jpeg,.png">
                    @if($errors->first('imagefile')) <p class="text-danger">{{ $errors->first('imagefile') }}</p> @endif
                  </div>
                </div>


                <div class="form-group">
                  <label class="control-label col-sm-2">Button Name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter button name" name="button_name" required value="{{ $data->button_name }}">
                    @if($errors->first('button_name')) <p class="text-danger">{{ $errors->first('button_name') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Dine</label>
                  <div class="col-sm-10 add_contactno" id="add_contactno">
                    <div class="input-group">
                        <select class="form-control" name="dine_ids[]" id="dine_ids" multiple data-placeholder="Please select dines">

                           @php
                              $out = array();
                            @endphp
                           @foreach($data->dines as $v)
                            @php 
                              array_push($out, $v->dine_id);
                            @endphp
                           @endforeach
                          {{print_r($out)}}
                          @foreach($category as $key=>$value)
                          <option value="{{$value->id}}" {{in_array($value->id,$out)?'selected':''}}>{{$value->name}}</option>
                          @endforeach
                        </select>
                        @if($errors->first('dine_ids')) <p class="text-danger">{{ $errors->first('dine_ids') }}</p> @endif
                        
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Food Court</label>
                  <div class="col-sm-10 add_contactno" id="add_contactno">
                    <div class="input-group">
                        <select class="form-control" name="fc_outlets[]" id="fc_outlets" multiple data-placeholder="Please select food court outlets">

                           @php
                              $out = array();
                            @endphp
                           @foreach($data->fc_outlets as $v)
                            @php 
                              array_push($out, $v->dine_id);
                            @endphp
                           @endforeach
                          {{print_r($out)}}
                          @foreach($category as $key=>$value)
                          <option value="{{$value->id}}" {{in_array($value->id,$out)?'selected':''}}>{{$value->name}}</option>
                          @endforeach
                        </select>
                        @if($errors->first('fc_outlets')) <p class="text-danger">{{ $errors->first('fc_outlets') }}</p> @endif
                        
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Unlimited</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="unlimited" required>
                      <option value="" selected disabled>--Please Select--</option>
                      <option value="1" {{ $data->unlimited=='1'?'selected':'' }}>Yes</option>
                      <option value="0" {{ $data->unlimited=='0'?'selected':'' }}>No</option>
                    </select>
                    @if($errors->first('unlimited')) <p class="text-danger">{{ $errors->first('unlimited') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Active</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="active" required>
                      <option value="" selected disabled>--Please Select--</option>
                      <option value="1" {{ $data->active=='1'?'selected':'' }}>Yes</option>
                      <option value="0" {{ $data->active=='0'?'selected':'' }}>No</option>
                    </select>
                    @if($errors->first('active')) <p class="text-danger">{{ $errors->first('active') }}</p> @endif
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="box-footer text-right">
                  <a class="btn btn-primary pull-left waves-effect" href="admin/contest/">Back</a>
                  <button type="submit" class="btn btn-success waves-effect">Save</button>
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

<script src="bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(document).ready(function() {
    
   CKEDITOR.replace('description');
    CKEDITOR.replace('terms');
    $('[name="form_date"]').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
    $('[name="to_date"]').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
  });



</script>

@endsection