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
      <li><a href="admin/app_offer">App Exclusive Offers</a></li>
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
              <div class="col-sm-12">

                <div class="form-group">
                  <label class="control-label col-sm-2">Store/Dine</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                        <select class="form-control" name="store_id" required>
                          <option value="" selected disabled>-- Select a store/dine --</option>
                          @foreach($store as $key=>$value)
                          <option value="{{$value->id}}" {{$value->id == $data->store_id?'selected':''}}>{{$value->name}}</option>
                          @endforeach
                        </select>
                        @if($errors->first('store_id')) <p class="text-danger">{{ $errors->first('store_id') }}</p> @endif
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" required placeholder="Enter title" name="title" value="{{ $data->title }}">
                    @if($errors->first('title')) <p class="text-danger">{{ $errors->first('title') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Description</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" rows="5" required placeholder="Enter Description" name="description">{{ $data->description }}</textarea>
                    @if($errors->first('description')) <p class="text-danger">{{ $errors->first('description') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Start Date</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter start date" name="start_date" value="{{ $data->start_date }}">
                    @if($errors->first('start_date')) <p class="text-danger">{{ $errors->first('start_date') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">End Date</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter end date" name="end_date" value="{{ $data->end_date }}">
                    @if($errors->first('end_date')) <p class="text-danger">{{ $errors->first('end_date') }}</p> @endif
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

                <div class="form-group">
                  <label class="control-label col-sm-2">Offer Availability</label>
                  <div class="col-sm-10">
                    <table class="table table-condensed">
                      <tr>
                        <th>Day</th>
                        <th style="text-align:center">From</th>
                        <th style="text-align:center">To</th>
                      </tr>
                      <tr>
                        <td>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value="Monday" name="activeday[]" {{$data->activeday->where('day','Monday')->count()?'checked':''}}> Monday
                            </label>
                          </div>
                        </td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{$data->activeday->where('day','Monday')->count()?$data->activeday->where('day','Monday')->first()->fromtime:''}}"></td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{$data->activeday->where('day','Monday')->count()?$data->activeday->where('day','Monday')->first()->totime:''}}"></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value="Tuesday" name="activeday[]" {{$data->activeday->where('day','Tuesday')->count()?'checked':''}}> Tuesday
                            </label>
                          </div>
                        </td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{$data->activeday->where('day','Tuesday')->count()?$data->activeday->where('day','Tuesday')->first()->fromtime:''}}"></td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{$data->activeday->where('day','Tuesday')->count()?$data->activeday->where('day','Tuesday')->first()->totime:''}}"></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value="Wednesday" name="activeday[]" {{$data->activeday->where('day','Wednesday')->count()?'checked':''}}> Wednesday
                            </label>
                          </div>
                        </td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{$data->activeday->where('day','Wednesday')->count()?$data->activeday->where('day','Wednesday')->first()->fromtime:''}}"></td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{$data->activeday->where('day','Wednesday')->count()?$data->activeday->where('day','Wednesday')->first()->totime:''}}"></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value="Thursday" name="activeday[]" {{$data->activeday->where('day','Thursday')->count()?'checked':''}}> Thursday
                            </label>
                          </div>
                        </td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{$data->activeday->where('day','Thursday')->count()?$data->activeday->where('day','Thursday')->first()->fromtime:''}}"></td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{$data->activeday->where('day','Thursday')->count()?$data->activeday->where('day','Thursday')->first()->totime:''}}"></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value="Friday" name="activeday[]" {{$data->activeday->where('day','Friday')->count()?'checked':''}}> Friday
                            </label>
                          </div>
                        </td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{$data->activeday->where('day','Friday')->count()?$data->activeday->where('day','Friday')->first()->fromtime:''}}"></td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{$data->activeday->where('day','Friday')->count()?$data->activeday->where('day','Friday')->first()->totime:''}}"></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value="Saturday" name="activeday[]" {{$data->activeday->where('day','Saturday')->count()?'checked':''}}> Saturday
                            </label>
                          </div>
                        </td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{$data->activeday->where('day','Saturday')->count()?$data->activeday->where('day','Saturday')->first()->fromtime:''}}"></td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{$data->activeday->where('day','Saturday')->count()?$data->activeday->where('day','Saturday')->first()->totime:''}}"></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value="Sunday" name="activeday[]" {{$data->activeday->where('day','Sunday')->count()?'checked':''}}> Sunday
                            </label>
                          </div>
                        </td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{$data->activeday->where('day','Sunday')->count()?$data->activeday->where('day','Sunday')->first()->fromtime:''}}"></td>
                        <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{$data->activeday->where('day','Sunday')->count()?$data->activeday->where('day','Sunday')->first()->totime:''}}"></td>
                      </tr>
                    </table>
                    @if($errors->first('activeday')) <p class="text-danger">Please select at least one day of the week.</p> @endif
                    @if(($errors->first('activeday') == "") and ($errors->first('fromtime') || $errors->first('totime') || $errors->first('fromtime.*') || $errors->first('totime.*'))) <p class="text-danger">Please enter valid time of the selected weekdays.</p> @endif
                  </div>
                </div>

              </div>

              <div class="col-sm-12">
                <div class="box-footer text-right">
                  <a class="btn btn-primary pull-left waves-effect" href="admin/app_offer">Back</a>
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


<script>
  $(document).ready(function() {
    $('[name="start_date"],[name="end_date"]').datetimepicker({format: 'YYYY-MM-DD'});
    $('[name="fromtime[]"],[name="totime[]"]').datetimepicker({format: 'hh:mm a'});
    $('[name="activeday[]"]').each(function(index, el) {
      if(el.checked) $(el).closest('tr').find('[name="fromtime[]"],[name="totime[]"]').removeAttr('disabled').prop('required',true)
    });
  });

  $('[name="activeday[]"]').change(function(event) {
    
    if(this.checked){
      $(this).closest('tr').find('[name="fromtime[]"]').val('12:00 am')
      $(this).closest('tr').find('[name="totime[]"]').val('11:59 pm')
      $(this).closest('tr').find('[name="fromtime[]"],[name="totime[]"]').removeAttr('disabled')
      $(this).closest('tr').find('[name="fromtime[]"],[name="totime[]"]').prop('required',true)
    }else{
      $(this).closest('tr').find('[name="fromtime[]"],[name="totime[]"]').val('')
      $(this).closest('tr').find('[name="fromtime[]"],[name="totime[]"]').removeAttr('required')
      $(this).closest('tr').find('[name="fromtime[]"],[name="totime[]"]').prop('disabled', true)
    }
  });
</script>

@endsection