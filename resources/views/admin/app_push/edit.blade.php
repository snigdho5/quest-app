@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Notification
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="admin/app_push">Push Notification</a></li>
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
                <img src="{{ asset('storage/app_push/actual/'.$data->image) }}" alt="..." class="img-responsive">
                @else
                No image found.
                @endif
              </div>
              <div class="col-sm-10">

                <div class="form-group">
                  <label class="control-label col-sm-2">Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" required placeholder="Enter title" name="title" value="{{ $data->title }}">
                    @if($errors->first('title')) <p class="text-danger">{{ $errors->first('title') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Body</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" required placeholder="Enter Body" name="body">{{ $data->body }}</textarea>
                    @if($errors->first('body')) <p class="text-danger">{{ $errors->first('body') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Sub Text</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter sub text" name="subtext" value="{{ $data->subtext }}">
                    @if($errors->first('subtext')) <p class="text-danger">{{ $errors->first('subtext') }}</p> @endif
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-2">Type</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="type" required>
                      <option value="image" {{ $data->type == 'image'?'selected':'' }}>Image Notification</option>
                      <option value="text" {{ $data->type == 'text'?'selected':'' }}>Text Notification</option>
                    </select>
                    @if($errors->first('push')) <p class="text-danger">{{ $errors->first('push') }}</p> @endif
                  </div>
                </div>

                <div class="form-group" id="img" style="display: {{ $data->type == 'image'?'block':'none' }}">
                  <label class="control-label col-sm-2">Image (JPG) (2:1)<br><small>(Max 512kb)</small> </label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" name="imagefile" placeholder="Select Image" accept=".jpeg,.jpg">
                    @if($errors->first('imagefile')) <p class="text-danger">{{ $errors->first('imagefile') }}</p> @endif
                  </div>
                </div>

                {{-- <div class="form-group">
                  <label class="control-label col-sm-2">Activity</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="activity" required>
                      <option value="Main" {{ $data->activity == 'Main'?'selected':'' }}>Main Page</option>
                      <option value="Camera" {{ $data->activity == 'Camera'?'selected':'' }}>Camera Page</option>
                      <option value="NotificationPage" {{ $data->activity == 'NotificationPage'?'selected':'' }}>Notification Page</option>
                    </select>
                    @if($errors->first('activity')) <p class="text-danger">{{ $errors->first('activity') }}</p> @endif
                  </div>
                </div> --}}


                <div class="form-group">
                  <label class="control-label col-sm-2">App Page (optional)</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="activity" onchange="pageDetails(this.value)">
                      <option value="Main" selected>-- No Action --</option>
                      <option value="call" {{ $data->activity=='call'?'selected':'' }}>Home Page(SOS Call)</option>
                      <option value="store" {{ $data->activity=='store'?'selected':'' }}>Home Page(Store)</option>
                      <option value="dine" {{ $data->activity=='dine'?'selected':'' }}>Home Page(Dine)</option>
                      <option value="walknwin" {{ $data->activity=='walknwin'?'selected':'' }}>Home Page(Walknwin)</option>
                      <option value="dinenwin" {{ $data->page=='dinenwin'?'selected':'' }}>Dine n Win</option>
                      <option value="account" {{ $data->activity=='account'?'selected':'' }}>Account Page</option>
                      <option value="blogpage" {{ $data->activity=='blogpage'?'selected':'' }}>Blog Page</option>
                      <option value="camerapage" {{ $data->activity=='camerapage'?'selected':'' }}>Camera Page</option>
                      <option value="currentoffers" {{ $data->activity=='currentoffers'?'selected':'' }}>Currentoffers Page</option>
                      <option value="apponlyofferpage" {{ $data->activity=='apponlyofferpage'?'selected':'' }}>App Only Offer Page</option>
                      <option value="disclaimer" {{ $data->activity=='disclaimer'?'selected':'' }}>Disclaimer Page</option>
                      <option value="eventpage" {{ $data->activity=='eventpage'?'selected':'' }}>Event Page</option>
                      <option value="faq" {{ $data->activity=='faq'?'selected':'' }}>Faq Page</option>
                      <option value="feedback" {{ $data->activity=='feedback'?'selected':'' }}>Feedback Page</option>
                      <option value="loft" {{ $data->activity=='loft'?'selected':'' }}>Loft Page</option>
                      <option value="lofteventpage" {{ $data->activity=='lofteventpage'?'selected':'' }}>Loftevent Page</option>
                      <option value="mallmap" {{ $data->activity=='mallmap'?'selected':'' }}>Mallmap Page</option>
                      <option value="movies" {{ $data->activity=='movies'?'selected':'' }}>Movies Page</option>
                      <option value="notificationpage" {{ $data->activity=='notificationpage'?'selected':'' }}>Notification Page</option>
                      <option value="parking" {{ $data->activity=='parking'?'selected':'' }}>Parking Page</option>
                      <option value="policy" {{ $data->activity=='policy'?'selected':'' }}>Policy Page</option>
                      <option value="referpage" {{ $data->activity=='referpage'?'selected':'' }}>Refer Page</option>
                      <option value="terms" {{ $data->activity=='terms'?'selected':'' }}>Terms Page</option>
                      <option value="link" {{ $data->activity=='link'?'selected':'' }}>link Page</option>


                      <option value="bloginner" {{ $data->activity=='bloginner'?'selected':'' }}>Bloginner Page</option>
                      <option value="designerinner" {{ $data->activity=='designerinner'?'selected':'' }}>Designerinner Page</option>
                      <option value="dineinner" {{ $data->activity=='dineinner'?'selected':'' }}>Dineinner Page</option>
                      <option value="eventinner" {{ $data->activity=='eventinner'?'selected':'' }}>Eventinner Page</option>
                      <option value="lofteventinner" {{ $data->activity=='lofteventinner'?'selected':'' }}>Lofteventinner Page</option>
                      <option value="offerinner" {{ $data->activity=='offerinner'?'selected':'' }}>Offerinner Page</option>
                      <option value="storeinner" {{ $data->activity=='storeinner'?'selected':'' }}>Storeinner Page</option>
                    </select>
                    @if($errors->first('activity')) <p class="text-danger">{{ $errors->first('activity') }}</p> @endif
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
                  <label class="control-label col-sm-2">Send</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="push" required>
                      <option value="1" {{ $data->push == '1'?'selected':'' }}>Now</option>
                      <option value="0" {{ $data->push == '0'?'selected':'' }}>Later</option>
                    </select>
                    @if($errors->first('push')) <p class="text-danger">{{ $errors->first('push') }}</p> @endif
                  </div>
                </div>
              </div>

              <div class="col-sm-12">
                <div class="box-footer text-right">
                  <a class="btn btn-primary pull-left waves-effect" href="admin/app_push">Back</a>
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
    $('[name="activity"]').trigger('change');
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