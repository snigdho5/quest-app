
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Edit Admin
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?=base_url()?>admin/admin_manage/">Manage Admins</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    
    <div class="box">
      <div class="box-body">
        <div class="row">
          <div class="col-sm-12">
            <form class="form-horizontal" action="" method="post">
              <div class="form-group">
                <label class="control-label col-sm-2">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Enter name" name="name" required value="<?=$dataArr['adminArr'][0]['name']?>">
                  <?=form_error('name', '<p class="text-danger">', '</p>')?>  
                </div>            
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Type</label>
                <div class="col-sm-10">
                  <select class="form-control" name="role" required>
                    <option value="" selected disabled>Select Category</option>
                    <?php foreach($dataArr['catArr'] as $value):?>
                    <option value="<?=$value['id']?>" <?=$dataArr['adminArr'][0]['role']==$value['id']?'selected':''?>><?=$value['title']?></option>
                    <?php endforeach?>
                  </select>
                  <?=form_error('role', '<p class="text-danger">', '</p>')?>  
                </div>            
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Username</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Enter username" name="username" required value="<?=$dataArr['adminArr'][0]['username']?>">
                  <?=form_error('username', '<p class="text-danger">', '</p>')?>  
                </div>            
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2">Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" placeholder="Enter password" name="password" value="">
                  <?=form_error('password', '<p class="text-danger">', '</p>')?>  
                </div>            
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Active</label>
                <div class="col-sm-10">
                  <select class="form-control" name="active" required>
                    <option value="1" <?=$dataArr['adminArr'][0]['active']=='1'?'selected':''?>>Yes</option>
                    <option value="0" <?=$dataArr['adminArr'][0]['active']=='0'?'selected':''?>>No</option>
                  </select>
                  <?=form_error('active', '<p class="text-danger">', '</p>')?>   
                </div>            
              </div>
              <div class="form-group">
                <div class="col-sm-12 text-right">
                  <a class="btn btn-primary" href="<?=base_url()?>admin/admin_manage/">Back</a>
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
    //CKEDITOR.replace('content');
  });
    
</script>
