
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Pages
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?=base_url()?>admin/cms/">Custom Pages</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">

    <div class="box">
      <div class="box-body">
        <div class="row">
          <div class="col-sm-2">
            <p><b>Header Image:</b> <?php if($dataArr['cmsArr'][0]['image']){?><a href="<?=base_url()?>admin/cms/delimg/?id=<?=$dataArr['cmsArr'][0]['id']?>" class="btn btn-danger btn-xs pull-right">Delete</a><?php }?></p>
            <?php if($dataArr['cmsArr'][0]['image']){?>
            <img src="<?=base_url()?>uploads/cms/actual/<?=$dataArr['cmsArr'][0]['image']?>" alt="..." class="img-responsive">
            <?php }else echo 'No image found.';?>
            <hr>
            <p><b>Meta Image:</b></p>
            <?php if($dataArr['cmsArr'][0]['meta_image']){?>
            <img src="<?=base_url()?>uploads/link_data/actual/<?=$dataArr['cmsArr'][0]['meta_image']?>" alt="..." class="img-responsive">
            <?php }else echo 'No image found.';?>
          </div>
          <div class="col-sm-10">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label class="control-label col-sm-2">Title*</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Enter title" name="title" required value="<?=$dataArr['cmsArr'][0]['title']?>">
                  <?=form_error('title', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group hidden">
                <label class="control-label col-sm-2">Parent Page<br><small>(optional)</small></label>
                <div class="col-sm-10">
                  <select class="form-control" name="parent_id">
                    <option value="" selected disabled>Select Parent Page</option>
                    <?php foreach($dataArr['cmsArrAll'] as $value):?>
                      <?php if($value['id'] != $_GET['id']):?>
                    <option data-link="<?=$value['slug']?>" value="<?=$value['id']?>" <?=$dataArr['cmsArr'][0]['parent_id'] == $value['id']?'selected':''?>><?=$value['title']?></option>
                      <?php endif?>
                    <?php endforeach?>
                  </select>
                  <?=form_error('parent_id', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Seo URL*</label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-addon"><?=base_url()?><span id="parent_link"></span></span>
                    <input type="hidden" name="actual_value" required value="<?=$dataArr['cmsArr'][0]['slug']?>">
                    <input type="text" class="form-control" placeholder="Enter URL" name="slug" required value="<?=$dataArr['cmsArr'][0]['slug']?>" pattern="[0-9A-Za-z-_.]*" title="Allowed charaters A-Z, a-z, 0-9, '-', '_', '.'" readonly>
                    <span class="input-group-btn"><button onclick="readonly(this)" type="button" class="btn btn-default"><i class="fa fa-pencil fa-fw"></i></button></span>
                  </div>
                  <small><i class="fa fa-info-circle fa-fw"></i> Allowed charaters <b>A-Z</b>, <b>a-z</b>, <b>0-9</b>, dash <b>'-'</b></small>
                  <?=form_error('slug', '<p class="text-danger">', '</p>')?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2">Body Content*</label>
                <div class="col-sm-10">
                  <textarea id="content" class="form-control" name="content" rows="10"><?=$dataArr['cmsArr'][0]['content']?></textarea>
                  <small><i class="fa fa-info-circle fa-fw"></i> For dynamic module integration use <b>module_include[module_name, table_name]</b></small>
                  <?=form_error('content', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Header Image (JPEG)</label>
                <div class="col-sm-10">
                  <input type="file" class="form-control" name="image" placeholder="Select Image" accept=".jpg,.jpeg">
                  <small><i class="fa fa-info-circle fa-fw"></i> Please upload 1366px X 225px image.</small>
                  <?=isset($dataArr['ferr_msg'])?'<p class="text-danger">'.$dataArr['ferr_msg'].'</p>':''?>
                </div>
              </div>
              <p class="label-hr">SEO/Open Graph Content (optional)</p>
              <div class="form-group">
                <label class="control-label col-sm-2">Meta Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Enter Meta Title" name="meta_title" value="<?=$dataArr['cmsArr'][0]['meta_title']?>">
                  <?=form_error('meta_title', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Meta Description</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Enter Meta Description" name="meta_desc" value="<?=$dataArr['cmsArr'][0]['meta_desc']?>">
                  <?=form_error('meta_desc', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Meta Keyword</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Enter Meta Keyword" name="meta_keyword" value="<?=$dataArr['cmsArr'][0]['meta_keyword']?>">
                  <?=form_error('meta_keyword', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Meta Image (JPG or PNG)</label>
                <div class="col-sm-10">
                  <input type="file" class="form-control" name="meta_image" placeholder="Select Image" accept=".png,.jpeg,.jpg">
                  <?=isset($dataArr['err_msg'])?'<p class="text-danger">'.$dataArr['err_msg'].'</p>':''?>
                  <small><i class="fa fa-info-circle fa-fw"></i> Please upload 1200 x 630px image.</small>
                </div>
              </div>
              <p class="label-hr">Page Settings</p>
              <div class="form-group">
                <label class="control-label col-sm-2">Post Time*</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Enter date time" name="post_time" required value="<?=unix_to_human($dataArr['cmsArr'][0]['post_time'])?>">
                  <?=form_error('post_time', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Active</label>
                <div class="col-sm-10">
                  <select class="form-control" name="active" required>
                    <option value="1" <?=$dataArr['cmsArr'][0]['active']=='1'?'selected':''?>>Yes</option>
                    <option value="0" <?=$dataArr['cmsArr'][0]['active']=='0'?'selected':''?>>No</option>
                  </select>
                  <?=form_error('active', '<p class="text-danger">', '</p>')?>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-12 text-right">
                  <a class="btn btn-primary" href="<?=base_url()?>admin/cms/">Back</a>
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
  var r = true;
  var t='';
  $(document).ready(function() {
    $('select').select2();
    CKEDITOR.replace('content');
    $('[name="post_time"]').datetimepicker({format: 'YYYY-MM-DD hh:mm A'});
    $('[name="parent_id"]').trigger('change')
  });

  $('[name="title"]').keyup(function(event) {
    $('[name="slug"]').val($(this).val().toString()
    .trim()
    .toLowerCase()
    .replace(/\s+/g, "-")
    .replace(/[^\w\-]+/g, "")
    .replace(/\-\-+/g, "-")
    .replace(/^-+/, "")
    .replace(/-+$/, ""));

    clearTimeout(t);
    t = setTimeout(function(){
      checkSlug();
    },2500);

  });
   $('[name="slug"]').keyup(function(event) {
     clearTimeout(t);
      t = setTimeout(function(){
        checkSlug();
      },2500);
   });



  $('[name="parent_id"]').change(function(event) {
    link=$(this).find('option:selected').data('link');
    link = link[link.length - 1]=='/'?link:link+'/';
    $('#parent_link').text(link);
  });


  function checkSlug(){
    $.ajax({
      url: '<?=base_url()?>ajax/checkCmsSlug',
      type: 'POST',
      data: {slug: $('[name="slug"]').val(),id:"<?=$dataArr['cmsArr'][0]['id']?>"},
      success: function(data){
        console.log(data);
        $('[name="slug"]').val(data.trim());
      }
    });
  }

  function readonly(btn){
    $(btn).find('i').toggleClass('fa-pencil fa-close');
    if (r) {
      $(btn).closest('.input-group').find('input').prop('readonly',false);
      r = false;
    }else{
      $(btn).closest('.input-group').find('input').prop('readonly',true);
      r=true;
    }


  }

   var _URL = window.URL || window.webkitURL;
  $("[name='image']").change(function (e) {
      var file, img;
      if ((file = this.files[0])) {
          img = new Image();
          img.onload = function () {

              if((this.width < 1366 || this.height < 225)){
                $("[name='image']").val('');
                alert('Please select 1366px X 225px image.');
              }
          };
          img.src = _URL.createObjectURL(file);
      }
  });
  var _URL = window.URL || window.webkitURL;
  $("[name='meta_image']").change(function (e) {
      var file, img;
      if ((file = this.files[0])) {
          img = new Image();
          img.onload = function () {
              if(this.width != 1200 || this.height!= 630){
                $("[name='meta_image']").val('');
                alert('Please select 1200 x 630px image.');
              }
          };
          img.src = _URL.createObjectURL(file);
      }
  });
</script>
