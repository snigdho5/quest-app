<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Module
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?=base_url()?>admin/admin_module/">Admin Modules</a></li>
      <li class="active">Add New</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    
    <div class="box">
      <form class="form-horizontal" action="" method="post">
        <div class="box-body">
          <div class="form-group">
            <label class="control-label col-sm-2">Module</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter module" name="module" required value="<?=set_value('module')?>">
              <?=form_error('module', '<p class="text-danger">', '</p>')?>  
            </div>            
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Parent Module<br><small>(optional)</small></label>
            <div class="col-sm-10">
              <select class="form-control" name="parent_id">
                <option value="" selected disabled>Select Parent Module</option>
                <?php foreach($dataArr['modArr'] as $value):?>
                  <?php if($value['parent_id']=='0'):?>
                <option value="<?=$value['id']?>" <?=set_value('parent_id')==$value['id']?'selected':''?>><?=$value['module']?></option>
                <?php endif?>
                <?php endforeach?>
              </select>
              <?=form_error('parent_id', '<p class="text-danger">', '</p>')?>  
            </div>            
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Link</label>
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-addon"><?=base_url()?>admin/</span>
                <input type="text" class="form-control" placeholder="Enter link" name="link" value="<?=set_value('link')?>">
              </div>
              <small><i class="fa fa-info-circle fa-fw"></i> Enter <b>#</b> for parent menu.</small>
              <?=form_error('link', '<p class="text-danger">', '</p>')?>  
            </div>            
          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Icon<br><small>(optional)</small></label>
            <div class="col-sm-10">
              <select class="form-control" name="icon">
                <option value="" selected disabled>Select Icon</option>
                <?php
                $iconFile = read_file(base_url().'bower_components/font-awesome/css/font-awesome.min.css');
                preg_match_all("/[.]fa-[^:]*:/", $iconFile, $iconFile, PREG_SET_ORDER);
                $i=1;
                foreach($iconFile as $icon){
                  if($i>32){
                    $icon = str_replace('.fa-','',str_replace(':', '', $icon[0]));?>
                <option value="<?=$icon?>" <?=set_value('icon')==$icon?'selected':''?>><?=$icon?></option>
                  <?php }
                  $i++;
                }?>
              </select>
              
              <?=form_error('icon', '<p class="text-danger">', '</p>')?>  
            </div>            
          </div>

          <div class="form-group" id="parent_order">
            <label class="control-label col-sm-2">Show Before<br><small>(optional)</small></label>
            <div class="col-sm-10">
              <select class="form-control" name="show_before">
                <option value="" selected disabled>Select Module</option>
                <option value="0">Default Position</option>
                <?php foreach($dataArr['modArr'] as $value):?>
                  <?php if($value['parent_id']=='0'):?>
                <option value="<?=$value['id']?>" <?=set_value('show_before')==$value['id']?'selected':''?>><?=$value['module']?></option>
                <?php endif?>
                <?php endforeach?>
              </select>
              <?=form_error('show_before', '<p class="text-danger">', '</p>')?>  
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
          <a class="btn btn-primary" href="<?=base_url()?>admin/admin_module/">Back</a>
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
  $(document).ready(function() {
    $('select').select2();
    $('[name="icon"]').select2({
      templateResult: setIcon,
      templateSelection: setIcon
    });

    $('[name="parent_id"]').change(function(event) {
      $('#parent_order').hide()
      $('[name="show_before"]').val('').trigger('chnage');
    });
  });


  function setIcon (option) {
    if (!option.id) { return option.text; }
    var $option = $('<span><i class="fa fa-'+option.text+'" style="width:30px"></i> '+option.text+'</span>');
    return $option;
  }
    
</script>
