@extends('admin.layout.master')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Banner
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/app_banner">App Banner</a></li>
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
            <label class="control-label col-sm-2">Image (JPG) (4:3) </label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="imagefile" required placeholder="Select Image" accept=".jpeg,.jpg">
              @if($errors->first('imagefile')) <p class="text-danger">{{ $errors->first('imagefile') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">App Page (optional)</label>
            <div class="col-sm-10">
              <select class="form-control" name="page" onchange="pageDetails(this.value)">
                <option value="" selected>-- No Action --</option>
                <option value="call">Home Page(SOS Call)</option>
                <option value="store">Home Page(Store)</option>
                <option value="dine">Home Page(Dine)</option>
                <option value="walknwin">Home Page(Walknwin)</option>
                <option value="dinenwin">Dine n Win</option>
                <option value="account">Account Page</option>
                <option value="blogpage">Blog Page</option>
                <option value="camerapage">Camera Page</option>
                <option value="apponlyofferpage">App Only Offer Page</option>
                <option value="currentoffers">Current offers Page</option>
                <option value="disclaimer">Disclaimer Page</option>
                <option value="eventpage">Event Page</option>
                <option value="faq">Faq Page</option>
                <option value="feedback">Feedback Page</option>
                <option value="loft">Loft Page</option>
                <option value="lofteventpage">Loftevent Page</option>
                <option value="mallmap">Mallmap Page</option>
                <option value="movies">Movies Page</option>
                <option value="notificationpage">Notification Page</option>
                <option value="parking">Parking Page</option>
                <option value="policy">Policy Page</option>
                <option value="referpage">Refer Page</option>
                <option value="terms">Terms Page</option>
                <option value="link">link Page</option>


                <option value="bloginner">Bloginner Page</option>
                <option value="designerinner">Designerinner Page</option>
                <option value="dineinner">Dineinner Page</option>
                <option value="eventinner">Eventinner Page</option>
                <option value="lofteventinner">Lofteventinner Page</option>
                <option value="offerinner">Offerinner Page</option>
                <option value="storeinner">Storeinner Page</option>
              </select>
              @if($errors->first('page')) <p class="text-danger">{{ $errors->first('page') }}</p> @endif
            </div>
          </div>

          <div class="form-group optionalAction" style="display: none;">
            <label class="control-label col-sm-2">Page Data</label>
            <div class="col-sm-10">
              <select class="form-control" name="action">
              </select>
               @if($errors->first('action')) <p class="text-danger">{{ $errors->first('action') }}</p> @endif
            </div>
          </div>


          <div class="form-group optionalUrl" style="display: none;">
            <label class="control-label col-sm-2">Url</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" name="url" placeholder="Enter url">
            </div>
            @if($errors->first('url')) <p class="text-danger">{{ $errors->first('url') }}</p> @endif
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
        </div>
        <div class="box-footer text-right">
          <a class="btn btn-primary pull-left" href="admin/app_banner">Back</a>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>

function pageDetails(ele) {
  if((ele=='bloginner') || (ele=='designerinner') || (ele=='dineinner') || (ele=='eventinner') || (ele=='lofteventinner') || (ele=='offerinner') || (ele=='storeinner') || (ele=='dinenwin')){
    $('[name="action"]').prop('required', true);
    $('[name="url"]').prop('required', false);
    $('.optionalUrl').hide();
   $.ajax({
      url: '{{ url("/admin") }}/ajax/getAppBannerPageDetails',
      type: 'POST',
      data: {pageName: ele},
      success: function(data){
        data = JSON.parse(data);
        $('.optionalAction').show();
        $('[name="action"]').html('');

        $.each(data, function(index, val) {
         $('[name="action"]').append('<option value="'+val['id']+'">'+val['title']+'</option>')
         });
      }
    });

  }
  else if(ele=='link'){
    $('.optionalAction').hide();
    $('.optionalUrl').show();
    $('[name="action"]').prop('required', false);
    $('[name="url"]').prop('required', true);
  }
  else{
    $('.optionalAction').hide();
    $('.optionalUrl').hide();
    $('[name="action"]').prop('required', false);
    $('[name="url"]').prop('required', false);
  }
}
</script>
@endsection