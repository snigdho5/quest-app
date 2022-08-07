
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    View Website Navigation
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?=base_url()?>admin/navigation/">Website Navigation</a></li>
      <li class="active">View</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    
    <div class="box">
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <form class="form-horizontal" action="" method="post" onsubmit="return false">
              <div class="form-group">
                <label class="control-label col-sm-2">Menu</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['navArr'][0]['menu']?>">
                </div>            
              </div>
              
              <div class="form-group">
                <label class="control-label col-sm-2">Link</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['navArr'][0]['link']?>">
                </div>            
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Parent Menu</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=get_anydata('arg_navigation','menu',$dataArr['navArr'][0]['parent_id'])?>">
                </div>            
              </div>

              <div id="parentdetails" style="display: <?=$dataArr['navArr'][0]['parent_id']=='0'?'block':'none'?>">
                <div class="form-group">
                  <label class="control-label col-sm-2">Menu Type</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="<?=$dataArr['navArr'][0]['mega']=='0'?'Normal':''?><?=$dataArr['navArr'][0]['mega']=='1'?'Full-Width Megamenu':''?><?=$dataArr['navArr'][0]['mega']=='2'?'Half-Width Megamenu':''?><?=$dataArr['navArr'][0]['mega']=='3'?'Custom-Width Megamenu':''?>">
                  </div>            
                </div>
                <div class="form-group" id="varwidth" style="display: <?=$dataArr['navArr'][0]['mega']=='3'?'block':'none'?>">
                  <label class="control-label col-sm-2">Dropdown Width</label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <input type="number" class="form-control" placeholder="Enter width" readonly value="<?=$dataArr['navArr'][0]['width']?>">
                      <span class="input-group-addon">%</span>
                    </div>
                  </div>            
                </div>
              </div>

              <div id="childdetails" style="display: <?=$dataArr['navArr'][0]['parent_id']=='0'?'none':'block'?>">
                <div class="form-group">
                  <label class="control-label col-sm-2">Class</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" readonly value="<?=$dataArr['navArr'][0]['class']?>">
                  </div>            
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2">Content</label>
                  <div class="col-sm-10">
                     <?=$dataArr['navArr'][0]['content']?> <br> <small class="text-danger">(For style and format view in frontend)</small>
                  </div>            
                </div>
              </div>

              
              <div class="form-group">
                <label class="control-label col-sm-2">Active</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['navArr'][0]['active']=='0'?'No':'Yes'?>">
                </div>            
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Created</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=unix_to_human($dataArr['navArr'][0]['created'])?>">
                </div>            
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Modified</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=unix_to_human($dataArr['navArr'][0]['modified'])?>">
                </div>            
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Post Time</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=unix_to_human($dataArr['navArr'][0]['post_time'])?>">
                </div>            
              </div>
            </form>
          </div>
          
        </div>
        <a class="btn btn-primary pull-right" href="<?=base_url()?>admin/navigation/">Back</a>
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
