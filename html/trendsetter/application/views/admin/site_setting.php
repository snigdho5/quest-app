<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Site Settings
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Site Settings</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <?php if($this->session->flashdata('success')) echo '<p class="alert alert-success"><i class="fa fa-fw fa-check"></i>'.$this->session->flashdata('success').'</p>';?>
    <?php if($this->session->flashdata('error')) echo '<p class="alert alert-danger"><i class="fa fa-fw fa-warning"></i>'.$this->session->flashdata('error').'</p>';?>
    <div class="box">
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
              <p class="label-hr">Image and Icon</p>
              <div class="form-group">
                <label class="control-label col-sm-2">Header logo (PNG)</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-addon img"><img src="<?=base_url()?>uploads/logo_icon/<?=$dataArr['settingArr'][0]['logo']?>" alt="logo"></span>
                    <input type="file" class="form-control" name="logo" placeholder="Select Image" accept=".png">
                    <?=isset($dataArr['err_msg'])?'<p class="text-danger">'.$dataArr['err_msg'].'</p>':''?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Footer logo (PNG)</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-addon img"><img src="<?=base_url()?>uploads/logo_icon/<?=$dataArr['settingArr'][0]['flogo']?>" alt="logo"></span>
                    <input type="file" class="form-control" name="flogo" placeholder="Select Image" accept=".png">
                    <?=isset($dataArr['ferr_msg'])?'<p class="text-danger">'.$dataArr['ferr_msg'].'</p>':''?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Favicon (PNG)</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-addon img"><img src="<?=base_url()?>uploads/logo_icon/<?=$dataArr['settingArr'][0]['favicon']?>" alt=""></span>
                    <input type="file" class="form-control" name="favicon" placeholder="Select Image" accept=".png">
                    <?=isset($dataArr['ierr_msg'])?'<p class="text-danger">'.$dataArr['ierr_msg'].'</p>':''?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Login Background (JPG)</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-addon img"><img src="<?=base_url()?>uploads/logo_icon/<?=$dataArr['settingArr'][0]['login_back']?>" alt=""></span>
                    <input type="file" class="form-control" name="login_back" placeholder="Select Image" accept=".jpeg,.jpg">
                    <?=isset($dataArr['jerr_msg'])?'<p class="text-danger">'.$dataArr['jerr_msg'].'</p>':''?>
                  </div>
                </div>
              </div>
              <p class="label-hr">Social Links</p>
              <div class="form-group">
                <label class="control-label col-sm-2">Facebook</label>
                <div class="col-sm-10">
                  <input type="url" class="form-control" placeholder="Enter facebook link" name="facebook" value="<?=$dataArr['settingArr'][0]['facebook']?>">
                  <?=form_error('password', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group hidden">
                <label class="control-label col-sm-2">Instagram</label>
                <div class="col-sm-10">
                  <input type="url" class="form-control" placeholder="Enter instagram link" name="instagram" value="<?=$dataArr['settingArr'][0]['instagram']?>">
                  <?=form_error('instagram', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Linkedin</label>
                <div class="col-sm-10">
                  <input type="url" class="form-control" placeholder="Enter Linkedin link" name="linkedin" value="<?=$dataArr['settingArr'][0]['linkedin']?>">
                  <?=form_error('linkedin', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Twitter</label>
                <div class="col-sm-10">
                  <input type="url" class="form-control" placeholder="Enter twitter link" name="twitter" value="<?=$dataArr['settingArr'][0]['twitter']?>">
                  <?=form_error('twitter', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group hidden">
                <label class="control-label col-sm-2">Youtube</label>
                <div class="col-sm-10">
                  <input type="url" class="form-control" placeholder="Enter youtube link" name="youtube" value="<?=$dataArr['settingArr'][0]['youtube']?>">
                  <?=form_error('youtube', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group hidden">
                <label class="control-label col-sm-2">Pinterest</label>
                <div class="col-sm-10">
                  <input type="url" class="form-control" placeholder="Enter pinterest link" name="pinterest" value="<?=$dataArr['settingArr'][0]['pinterest']?>">
                  <?=form_error('pinterest', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <p class="label-hr">Information</p>
              <div class="form-group">
                <label class="control-label col-sm-2">Contact Email</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" placeholder="Enter Contact Email" name="email" value="<?=$dataArr['settingArr'][0]['email']?>">
                  <?=form_error('email', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Disclaimer</label>
                <div class="col-sm-10">
                  <textarea id="content" class="form-control" name="disclaimer" rows="10"><?=$dataArr['settingArr'][0]['disclaimer']?></textarea>
                  <?=form_error('disclaimer', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Disclaimer Logo (PNG)</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-addon img"><img src="<?=base_url()?>uploads/logo_icon/<?=$dataArr['settingArr'][0]['disc_logo']?>" alt=""></span>
                    <input type="file" class="form-control" name="disc_logo" placeholder="Select Image" accept=".png">
                    <?=isset($dataArr['iderr_msg'])?'<p class="text-danger">'.$dataArr['iderr_msg'].'</p>':''?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Disclaimer Background (JPG)</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-addon img"><img src="<?=base_url()?>uploads/logo_icon/<?=$dataArr['settingArr'][0]['disc_img']?>" alt=""></span>
                    <input type="file" class="form-control" name="disc_img" placeholder="Select Image" accept=".jpeg,.jpg">
                    <?=isset($dataArr['idberr_msg'])?'<p class="text-danger">'.$dataArr['idberr_msg'].'</p>':''?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Who we are Quotation</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="who_we_qt" rows="5"><?=$dataArr['settingArr'][0]['who_we_qt']?></textarea>
                  <?=form_error('who_we_qt', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Our people Quotation</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="our_people_qt" rows="5"><?=$dataArr['settingArr'][0]['our_people_qt']?></textarea>
                  <?=form_error('our_people_qt', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <!-- <div class="form-group">
                <label class="control-label col-sm-2">Address and Contact Information</label>
                <div class="col-sm-10">
                  <textarea id="content1" class="form-control" name="address" rows="10"><?=$dataArr['settingArr'][0]['address']?></textarea>
                  <?=form_error('address', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Google Map</label>
                <div class="col-sm-10">
                  <input type="url" class="form-control" placeholder="Enter google map embed link" name="google_map" value="<?=$dataArr['settingArr'][0]['google_map']?>">
                  <?=form_error('google_map', '<p class="text-danger">', '</p>')?>
                </div>
              </div> -->
              <p class="label-hr">Other Codes</p>
              <div class="form-group">
                <label class="control-label col-sm-2">Analytic Script</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="ggl_analytic" rows="5"><?=$dataArr['settingArr'][0]['ggl_analytic']?></textarea>
                  <?=form_error('ggl_analytic', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Analytic Script (noscript)</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="ggl_analytic_ns" rows="5"><?=$dataArr['settingArr'][0]['ggl_analytic_ns']?></textarea>
                  <?=form_error('ggl_analytic_ns', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12 text-right">
                  <button type="submit" class="btn btn-success">Save</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?=base_url()?>bower_components/select2/dist/js/select2.min.js"></script>
<script src="<?=base_url()?>bower_components/ckeditor/ckeditor.js"></script>
<script>
  $(document).ready(function() {
    $('select').select2();
    CKEDITOR.replace('content');
    CKEDITOR.replace('content1');
  });
</script>
