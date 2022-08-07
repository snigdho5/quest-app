<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    New Type
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?=base_url()?>admin/admin_type/">Admin Type</a></li>
      <li class="active">Add New</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    
    <div class="box">
      <form class="form-horizontal" action="" method="post">
        <div class="box-body">
          <div class="form-group">
            <label class="control-label col-sm-2">Type</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter type" name="title" required value="<?=set_value('title')?>">
              <?=form_error('title', '<p class="text-danger">', '</p>')?>  
            </div>            
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2">Modules</label>
            <div class="col-sm-10">
              <select class="form-control" name="module[]" required multiple data-placeholder="Select Modules">
                <?php foreach($dataArr['modArr'] as $value):?>
                  <?php if(count_rows('arg_admin_module','parent_id='.$value['id']) == 0):?>
                <option value="<?=$value['id']?>"><?=$value['parent_id']=='0'?$value['module']:get_anydata('arg_admin_module','module',$value['parent_id']).' >> '.$value['module']?></option>
                  <?php endif?>
                <?php endforeach?>
              </select>
              <?=form_error('parent_id', '<p class="text-danger">', '</p>')?>  
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
          <a class="btn btn-primary" href="<?=base_url()?>admin/admin_type/">Back</a>
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
    //CKEDITOR.replace('content');
  });
    
</script>
