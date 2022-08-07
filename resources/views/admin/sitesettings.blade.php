@extends('admin.layout.master')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Site Settings
    </h1>
    <ol class="breadcrumb">
      <li><a href="admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Site Settings</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    @if(session('success'))
      <p class="alert alert-success"><i class="fa fa-fw fa-check"></i>{{ session('success') }}</p>
    @endif
    @if(session('error'))
      <p class="alert alert-danger"><i class="fa fa-fw fa-warning"></i>{{ session('error') }}</p>
    @endif

    <div class="box">
      <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="box-body">
          <p class="label-hr">Image and Icon</p>
          <div class="form-group">
            <label class="control-label col-sm-2">Logo (PNG)</label>
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-addon img"><img src="{{ asset('storage/logo_icon/'.$data->logo) }}" alt="logo"></span>
                <input type="file" class="form-control" name="logo_file" placeholder="Select Image" accept=".png">
                @if($errors->first('logo')) <p class="text-danger">{{ $errors->first('logo') }}</p> @endif
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Menu Logo (PNG)</label>
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-addon img"><img src="{{ asset('storage/logo_icon/'.$data->flogo) }}" alt="flogo"></span>
                <input type="file" class="form-control" name="flogo_file" placeholder="Select Image" accept=".png">
                @if($errors->first('flogo')) <p class="text-danger">{{ $errors->first('flogo') }}</p> @endif
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Company Logo (PNG)</label>
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-addon img"><img src="{{ asset('storage/logo_icon/'.$data->companylogo) }}" alt="companylogo"></span>
                <input type="file" class="form-control" name="companylogo_file" placeholder="Select Image" accept=".png">
                @if($errors->first('companylogo')) <p class="text-danger">{{ $errors->first('companylogo') }}</p> @endif
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Favicon (PNG)</label>
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-addon img"><img src="{{ asset('storage/logo_icon/'.$data->favicon) }}" alt=""></span>
                <input type="file" class="form-control" name="favicon_file" placeholder="Select Image" accept=".png">
                @if($errors->first('favicon')) <p class="text-danger">{{ $errors->first('favicon') }}</p> @endif
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Login Background (JPG)</label>
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-addon img"><img src="{{ asset('storage/logo_icon/'.$data->login_back) }}" alt=""></span>
                <input type="file" class="form-control" name="login_back_file" placeholder="Select Image" accept=".jpeg,.jpg">
                @if($errors->first('login_back')) <p class="text-danger">{{ $errors->first('login_back') }}</p> @endif
              </div>
            </div>
          </div>
          <p class="label-hr">Social Links</p>
          <div class="form-group">
            <label class="control-label col-sm-2">Facebook</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" placeholder="Enter facebook link" name="facebook" value="{{ old('facebook',$data->facebook) }}">
              @if($errors->first('facebook')) <p class="text-danger">{{ $errors->first('facebook') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Instagram</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" placeholder="Enter instagram link" name="instagram" value="{{ old('instagram',$data->instagram) }}">
              @if($errors->first('instagram')) <p class="text-danger">{{ $errors->first('instagram') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Twitter</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" placeholder="Enter twitter link" name="twitter" value="{{ old('twitter',$data->twitter) }}">
              @if($errors->first('twitter')) <p class="text-danger">{{ $errors->first('twitter') }}</p> @endif
            </div>
          </div>
          <p class="label-hr">Information</p>
          <div class="form-group">
            <label class="control-label col-sm-2">Website Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter website title" required name="title" value="{{ old('title',$data->title) }}">
              @if($errors->first('title')) <p class="text-danger">{{ $errors->first('title') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Contact Address</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter Contact Address" name="address" value="{{ old('address',$data->address) }}">
              @if($errors->first('address')) <p class="text-danger">{{ $errors->first('address') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Contact Email</label>
            <div class="col-sm-10">
              <input type="email" class="form-control" placeholder="Enter Contact Email" name="email" value="{{ old('email',$data->email) }}">
              @if($errors->first('email')) <p class="text-danger">{{ $errors->first('email') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Contact Phone</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter Contact Phone" name="phone" value="{{ old('phone',$data->phone) }}">
              @if($errors->first('phone')) <p class="text-danger">{{ $errors->first('phone') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Google Map</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" placeholder="Enter google map embed link" name="google_map" value="{{ old('google_map',$data->google_map) }}">
              @if($errors->first('google_map')) <p class="text-danger">{{ $errors->first('google_map') }}</p> @endif
            </div>
          </div>

          <p class="label-hr">HEAD tag codes</p>
          <div class="form-group">
            <label class="control-label col-sm-2">Analytic Script</label>
            <div class="col-sm-10">
              <textarea class="form-control" name="ggl_analytic" rows="5">{{ old('ggl_analytic',$data->ggl_analytic) }}</textarea>
              @if($errors->first('ggl_analytic')) <p class="text-danger">{{ $errors->first('ggl_analytic') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Analytic Script (noscript)</label>
            <div class="col-sm-10">
              <textarea class="form-control" name="ggl_analytic_ns" rows="5">{{ old('ggl_analytic_ns',$data->ggl_analytic_ns) }}</textarea>
              @if($errors->first('ggl_analytic_ns')) <p class="text-danger">{{ $errors->first('ggl_analytic_ns') }}</p> @endif
            </div>
          </div>

          <p class="label-hr">App Information</p>
          <div class="form-group">
            <label class="control-label col-sm-2">Android App Link</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" placeholder="Enter android app link" name="android_app" value="{{ old('android_app',$data->android_app) }}">
              @if($errors->first('android_app')) <p class="text-danger">{{ $errors->first('android_app') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Android App Version</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter android app vesion" name="app_version_and" value="{{ old('app_version_and',$data->app_version_and) }}">
              @if($errors->first('app_version_and')) <p class="text-danger">{{ $errors->first('app_version_and') }}</p> @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">iOS App Link</label>
            <div class="col-sm-10">
              <input type="url" class="form-control" placeholder="Enter ios app link" name="ios_app" value="{{ old('ios_app',$data->ios_app) }}">
              @if($errors->first('ios_app')) <p class="text-danger">{{ $errors->first('ios_app') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">iOS App Version</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter ios app vesion" name="app_version_ios" value="{{ old('app_version_ios',$data->app_version_ios) }}">
              @if($errors->first('app_version_ios')) <p class="text-danger">{{ $errors->first('app_version_ios') }}</p> @endif
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Terms and Conditions</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="content" name="app_terms" rows="5">{{ old('app_terms',$data->app_terms) }}</textarea>
              @if($errors->first('app_terms')) <p class="text-danger">{{ $errors->first('app_terms') }}</p> @endif
            </div>
          </div>


          <div class="form-group">
            <label class="control-label col-sm-2">Privacy Policy</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="content1" name="app_policies" rows="5">{{ old('app_policies',$data->app_policies) }}</textarea>
              @if($errors->first('app_policies')) <p class="text-danger">{{ $errors->first('app_policies') }}</p> @endif
            </div>
          </div>



          <div class="form-group">
            <label class="control-label col-sm-2">Disclaimer</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="content2" name="app_disc" rows="5">{{ old('app_disc',$data->app_disc) }}</textarea>
              @if($errors->first('app_disc')) <p class="text-danger">{{ $errors->first('app_disc') }}</p> @endif
            </div>
          </div>

        </div>
        <div class="box-footer text-right">
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
    </div>
  </section>
  <!-- /.content -->
</div>

<!-- /.content-wrapper -->
<script src="bower_components/select2/dist/js/select2.min.js"></script>
<script src="bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(document).ready(function() {
    $('select').select2();
    CKEDITOR.replace('content');
    CKEDITOR.replace('content1');
    CKEDITOR.replace('content2');
  });
</script>

@endsection


