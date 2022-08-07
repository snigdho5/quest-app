
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    View Page
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?=base_url()?>admin/cms/">Custom Pages</a></li>
      <li class="active">View</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">

    <div class="box">
      <div class="box-body">
        <div class="row">
          <div class="col-sm-2">

            <p><b>Header Image:</b></p>
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
            <form class="form-horizontal" action="" method="post" onsubmit="return false">
              <div class="form-group">
                <label class="control-label col-sm-2">Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['cmsArr'][0]['title']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Seo URL</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=base_url().($dataArr['cmsArr'][0]['parent_id']!='0'?get_anydata('arg_cms','slug',$dataArr['cmsArr'][0]['parent_id']).'/':'').$dataArr['cmsArr'][0]['slug']?>/">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Parent Page</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=get_anydata('arg_cms','title',$dataArr['cmsArr'][0]['parent_id'])?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Body Content</label>
                <div class="col-sm-10">
                  <div><?=$dataArr['cmsArr'][0]['content']?></div>
                </div>
              </div>
              <p class="label-hr">SEO/Open Graph Content</p>
              <div class="form-group">
                <label class="control-label col-sm-2">Meta Title</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['cmsArr'][0]['meta_title']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Meta Description</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['cmsArr'][0]['meta_desc']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Meta Keyword</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['cmsArr'][0]['meta_keyword']?>">
                </div>
              </div>
              <p class="label-hr">Page Settings</p>

              <div class="form-group">
                <label class="control-label col-sm-2">Active</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['cmsArr'][0]['active']=='0'?'No':'Yes'?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Created</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=unix_to_human($dataArr['cmsArr'][0]['created'])?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Modified</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=unix_to_human($dataArr['cmsArr'][0]['modified'])?>">
                </div>
              </div>
            </form>
          </div>

        </div>
        <a class="btn btn-primary pull-right" href="<?=base_url()?>admin/cms/">Back</a>
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
  });

</script>
