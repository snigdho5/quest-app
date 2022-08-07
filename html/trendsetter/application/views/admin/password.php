<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Change Password
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Change Password</li>
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
            <form class="form-horizontal" action="" method="post">
              <div class="form-group">
                <label class="control-label col-sm-2">New Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" placeholder="Enter new password" name="password" required>
                  <?=form_error('password', '<p class="text-danger">', '</p>')?>  
                </div>            
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Confirm Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" placeholder="Enter confirm password" name="cpassword" required>
                  <?=form_error('cpassword', '<p class="text-danger">', '</p>')?>  
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

