@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Banner
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/summer_banner">Special Banner</a></li>
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
                <img src="{{ asset('storage/summer_banner/actual/'.$data->image) }}" alt="..." class="img-responsive">
                @else
                No image found.
                @endif
              </div>
              <div class="col-sm-10">

                <div class="form-group">
                  <label class="control-label col-sm-2">Image (JPG) (4:3)</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" name="imagefile" placeholder="Select Image" accept=".jpeg,.jpg">
                    @if($errors->first('imagefile')) <p class="text-danger">{{ $errors->first('imagefile') }}</p> @endif
                  </div>
                </div>

                <div class="form-group" style="display: none;">
                  <label class="control-label col-sm-2">App Page (optional)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="page"  onchange="pageDetails(this.value)">
                      <option value="" selected>-- No Action --</option>
                      <option value="call" {{ $data->page=='call'?'selected':'' }}>Home Page(SOS Call)</option>
                      <option value="store" {{ $data->page=='store'?'selected':'' }}>Home Page(Store)</option>
                      <option value="dine" {{ $data->page=='dine'?'selected':'' }}>Home Page(Dine)</option>
                      <option value="walknwin" {{ $data->page=='walknwin'?'selected':'' }}>Home Page(Walknwin)</option>

                      <option value="dinenwin" {{ $data->page=='dinenwin'?'selected':'' }}>Dine n Win</option>

                      <option value="account" {{ $data->page=='account'?'selected':'' }}>Account Page</option>
                      <option value="blogpage" {{ $data->page=='blogpage'?'selected':'' }}>Blog Page</option>
                      <option value="camerapage" {{ $data->page=='camerapage'?'selected':'' }}>Camera Page</option>
                      <option value="apponlyofferpage" {{ $data->page=='apponlyofferpage'?'selected':'' }}>App Only Offer Page</option>
                      <option value="currentoffers" {{ $data->page=='currentoffers'?'selected':'' }}>Currentoffers Page</option>
                      <option value="disclaimer" {{ $data->page=='disclaimer'?'selected':'' }}>Disclaimer Page</option>
                      <option value="eventpage" {{ $data->page=='eventpage'?'selected':'' }}>Event Page</option>
                      <option value="faq" {{ $data->page=='faq'?'selected':'' }}>Faq Page</option>
                      <option value="feedback" {{ $data->page=='feedback'?'selected':'' }}>Feedback Page</option>
                      <option value="loft" {{ $data->page=='loft'?'selected':'' }}>Loft Page</option>
                      <option value="lofteventpage" {{ $data->page=='lofteventpage'?'selected':'' }}>Loftevent Page</option>
                      <option value="mallmap" {{ $data->page=='mallmap'?'selected':'' }}>Mallmap Page</option>
                      <option value="movies" {{ $data->page=='movies'?'selected':'' }}>Movies Page</option>
                      <option value="notificationpage" {{ $data->page=='notificationpage'?'selected':'' }}>Notification Page</option>
                      <option value="parking" {{ $data->page=='parking'?'selected':'' }}>Parking Page</option>
                      <option value="policy" {{ $data->page=='policy'?'selected':'' }}>Policy Page</option>
                      <option value="referpage" {{ $data->page=='referpage'?'selected':'' }}>Refer Page</option>
                      <option value="terms" {{ $data->page=='terms'?'selected':'' }}>Terms Page</option>
                      <option value="link" {{ $data->page=='link'?'selected':'' }}>link Page</option>


                      <option value="bloginner" {{ $data->page=='bloginner'?'selected':'' }}>Bloginner Page</option>
                      <option value="designerinner" {{ $data->page=='designerinner'?'selected':'' }}>Designerinner Page</option>
                      <option value="dineinner" {{ $data->page=='dineinner'?'selected':'' }}>Dineinner Page</option>
                      <option value="eventinner" {{ $data->page=='eventinner'?'selected':'' }}>Eventinner Page</option>
                      <option value="lofteventinner" {{ $data->page=='lofteventinner'?'selected':'' }}>Lofteventinner Page</option>
                      <option value="offerinner" {{ $data->page=='offerinner'?'selected':'' }}>Offerinner Page</option>
                      <option value="storeinner" {{ $data->page=='storeinner'?'selected':'' }}>Storeinner Page</option>
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
                    <input type="url" class="form-control" name="url" placeholder="Enter url" value="{{ $data->url}}">
                  </div>
                  @if($errors->first('url')) <p class="text-danger">{{ $errors->first('url') }}</p> @endif
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
                  <a class="btn btn-primary pull-left waves-effect" href="admin/summer_banner">Back</a>
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
  var action="{{ $data->action }}"
  $(document).ready(function() {
    // pageDetails({{$data->page}});
    $('[name="page"]').trigger('change');
  });

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
        if(action!=''){
           $('[name="action"]').val(action);
        }
        action = '';

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