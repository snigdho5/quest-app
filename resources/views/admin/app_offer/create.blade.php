@extends('admin.layout.master')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Offer
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/app_offer">App Exclusive Offers</a></li>
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
            <label class="control-label col-sm-2">Store/Dine</label>
            <div class="col-sm-10">
              <div class="input-group">
                  <select class="form-control" name="store_id" required>
                    <option value="" selected disabled>-- Select a store/dine --</option>
                    @foreach($store as $key=>$value)
                    <option value="{{$value->id}}" {{$value->id == old('store_id')?'selected':''}}>{{$value->name}}</option>
                    @endforeach
                  </select>
                  @if($errors->first('store_id')) <p class="text-danger">{{ $errors->first('store_id') }}</p> @endif
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required placeholder="Enter title" name="title" value="{{ old('title') }}">
              @if($errors->first('title')) <p class="text-danger">{{ $errors->first('title') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Description</label>
            <div class="col-sm-10">
              <textarea class="form-control" rows="5" required placeholder="Enter Description" name="description">{{ old('description') }}</textarea>
              @if($errors->first('description')) <p class="text-danger">{{ $errors->first('description') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Start Date</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter start date" name="start_date" value="{{ old('start_date') }}">
              @if($errors->first('start_date')) <p class="text-danger">{{ $errors->first('start_date') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">End Date</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter end date" name="end_date" value="{{ old('end_date') }}">
              @if($errors->first('end_date')) <p class="text-danger">{{ $errors->first('end_date') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Active</label>
            <div class="col-sm-10">
              <select class="form-control" name="active" required>
                <option value="1" selected>Yes</option>
                <option value="0">No</option>
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
                        <input type="checkbox" value="Monday" name="activeday[]" {{old('activeday')?(in_array('Monday',old('activeday'))?'checked':''):''}}> Monday
                      </label>
                    </div>
                  </td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{old('activeday')?(in_array('Monday',old('activeday'))?old('fromtime')[array_search('Monday', old('activeday'))]:''):''}}"></td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{old('activeday')?(in_array('Monday',old('activeday'))?old('totime')[array_search('Monday', old('activeday'))]:''):''}}"></td>
                </tr>
                <tr>
                  <td>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="Tuesday" name="activeday[]" {{old('activeday')?(in_array('Tuesday',old('activeday'))?'checked':''):''}}> Tuesday
                      </label>
                    </div>
                  </td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{old('activeday')?(in_array('Tuesday',old('activeday'))?old('fromtime')[array_search('Tuesday', old('activeday'))]:''):''}}"></td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{old('activeday')?(in_array('Tuesday',old('activeday'))?old('totime')[array_search('Tuesday', old('activeday'))]:''):''}}"></td>
                </tr>
                <tr>
                  <td>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="Wednesday" name="activeday[]" {{old('activeday')?(in_array('Wednesday',old('activeday'))?'checked':''):''}}> Wednesday
                      </label>
                    </div>
                  </td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{old('activeday')?(in_array('Wednesday',old('activeday'))?old('fromtime')[array_search('Wednesday', old('activeday'))]:''):''}}"></td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{old('activeday')?(in_array('Wednesday',old('activeday'))?old('totime')[array_search('Wednesday', old('activeday'))]:''):''}}"></td>
                </tr>
                <tr>
                  <td>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="Thursday" name="activeday[]" {{old('activeday')?(in_array('Thursday',old('activeday'))?'checked':''):''}}> Thursday
                      </label>
                    </div>
                  </td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{old('activeday')?(in_array('Thursday',old('activeday'))?old('fromtime')[array_search('Thursday', old('activeday'))]:''):''}}"></td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{old('activeday')?(in_array('Thursday',old('activeday'))?old('totime')[array_search('Thursday', old('activeday'))]:''):''}}"></td>
                </tr>
                <tr>
                  <td>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="Friday" name="activeday[]" {{old('activeday')?(in_array('Friday',old('activeday'))?'checked':''):''}}> Friday
                      </label>
                    </div>
                  </td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{old('activeday')?(in_array('Friday',old('activeday'))?old('fromtime')[array_search('Friday', old('activeday'))]:''):''}}"></td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{old('activeday')?(in_array('Friday',old('activeday'))?old('totime')[array_search('Friday', old('activeday'))]:''):''}}"></td>
                </tr>
                <tr>
                  <td>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="Saturday" name="activeday[]" {{old('activeday')?(in_array('Saturday',old('activeday'))?'checked':''):''}}> Saturday
                      </label>
                    </div>
                  </td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{old('activeday')?(in_array('Saturday',old('activeday'))?old('fromtime')[array_search('Saturday', old('activeday'))]:''):''}}"></td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{old('activeday')?(in_array('Saturday',old('activeday'))?old('totime')[array_search('Saturday', old('activeday'))]:''):''}}"></td>
                </tr>
                <tr>
                  <td>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="Sunday" name="activeday[]" {{old('activeday')?(in_array('Sunday',old('activeday'))?'checked':''):''}}> Sunday
                      </label>
                    </div>
                  </td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="fromtime[]" value="{{old('activeday')?(in_array('Sunday',old('activeday'))?old('fromtime')[array_search('Sunday', old('activeday'))]:''):''}}"></td>
                  <td><input type="text" class="form-control text-center" placeholder="--:-- --" disabled name="totime[]" value="{{old('activeday')?(in_array('Sunday',old('activeday'))?old('totime')[array_search('Sunday', old('activeday'))]:''):''}}"></td>
                </tr>
              </table>
              @if($errors->first('activeday')) <p class="text-danger">Please select at least one day of the week.</p> @endif
              @if(($errors->first('activeday') == "") and ($errors->first('fromtime') || $errors->first('totime') || $errors->first('fromtime.*') || $errors->first('totime.*'))) <p class="text-danger">Please enter valid time of the selected weekdays.</p> @endif
            </div>
          </div>

        </div>

        <div class="box-footer text-right">
          <a class="btn btn-primary pull-left" href="admin/app_offer">Back</a>
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