
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Page
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?=base_url()?>admin/cms/">Custom Page</a></li>
      <li class="active">Add New</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">

    <div class="box">
      <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <label class="control-label col-sm-2">Title*</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter title" name="title" required value="<?=set_value('title')?>">
              <?=form_error('title', '<p class="text-danger">', '</p>')?>
            </div>
          </div>
          <div class="form-group  hidden">
            <label class="control-label col-sm-2">Parent Page<br><small>(optional)</small></label>
            <div class="col-sm-10">
              <select class="form-control" name="parent_id">
                <option value="" selected disabled>Select Parent Page</option>
                <?php foreach($dataArr['cmsArr'] as $value):?>
                <option data-link="<?=$value['slug']?>" value="<?=$value['id']?>" <?=set_value('parent_id')==$value['id']?'selected':''?>><?=$value['title']?></option>
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
                <input type="text" class="form-control" readonly placeholder="Enter URL" name="slug" required value="<?=set_value('slug')?>" pattern="[0-9A-Za-z-]*" title="Allowed charaters A-Z, a-z, 0-9, '-'">
                <span class="input-group-btn"><button onclick="readonly(this)" type="button" class="btn btn-default"><i class="fa fa-pencil fa-fw"></i></button></span>
              </div>
              <small><i class="fa fa-info-circle fa-fw"></i> Allowed charaters <b>A-Z</b>, <b>a-z</b>, <b>0-9</b>, dash <b>'-'</b></small>
              <?=form_error('slug', '<p class="text-danger">', '</p>')?>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Body Content*</label>
            <div class="col-sm-10">
              <textarea id="content" class="form-control" name="content" rows="10"><?=set_value('content')?></textarea>
              <small><i class="fa fa-info-circle fa-fw"></i> For dynamic module integration use <b>module_include[module_name, table_name]</b></small>
              <?=form_error('content', '<p class="text-danger">', '</p>')?>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Header Image (JPEG)*</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="image"  placeholder="Select Image" accept=".jpg,.jpeg">
              <small><i class="fa fa-info-circle fa-fw"></i> Please upload 1366px X 225px image.</small>
              <?=isset($dataArr['ferr_msg'])?'<p class="text-danger">'.$dataArr['ferr_msg'].'</p>':''?>

            </div>
          </div>
          <p class="label-hr">SEO/Open Graph Content (optional)</p>

          <div class="form-group">
            <label class="control-label col-sm-2">Meta Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter Meta Title" name="meta_title" value="<?=set_value('meta_title')?>">
              <?=form_error('meta_title', '<p class="text-danger">', '</p>')?>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Meta Description</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter Meta Description" name="meta_desc" value="<?=set_value('meta_desc')?>">
              <?=form_error('meta_desc', '<p class="text-danger">', '</p>')?>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Meta Keyword</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter Meta Keyword" name="meta_keyword" value="<?=set_value('meta_keyword')?>">
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
              <input type="text" class="form-control" placeholder="Enter date time" name="post_time" required value="<?=set_value('post_time')?>">
              <?=form_error('post_time', '<p class="text-danger">', '</p>')?>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Active</label>
            <div class="col-sm-10">
              <select class="form-control" name="active" required>
                <option value="1" selected>Yes</option>
                <option value="0">No</option>
              </select>
              <?=form_error('active', '<p class="text-danger">', '</p>')?>
            </div>
          </div>
        </div>
        <div class="box-footer text-right">
          <a class="btn btn-primary" href="<?=base_url()?>admin/cms/">Back</a>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </form>
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
  });


  $('[name="parent_id"]').change(function(event) {
    link=$(this).find('option:selected').data('link');
    link = link[link.length - 1]=='/'?link:link+'/';
    $('#parent_link').text(link);
  });
  $('[name="post_time"]').datetimepicker({format: 'YYYY-MM-DD hh:mm A'});
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

  function checkSlug(){
    $.ajax({
      url: '<?=base_url()?>ajax/checkCmsSlug',
      type: 'POST',
      data: {slug: $('[name="slug"]').val()},
      success: function(data){
        console.log(data);
        $('[name="slug"]').val(data.trim());
      }
    });
  }

  var _URL = window.URL || window.webkitURL;
  $("[name='image']").change(function (e) {
      var file, img;
      if ((file = this.files[0])) {
          img = new Image();
          img.onload = function () {
              if(this.width != 1366 || this.height!= 225){
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
