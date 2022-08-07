<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Manage Admins
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Manage Admins</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <?php if($this->session->flashdata('success')) echo '<p class="alert alert-success"><i class="fa fa-fw fa-check"></i>'.$this->session->flashdata('success').'</p>';?>
    <?php if($this->session->flashdata('error')) echo '<p class="alert alert-danger"><i class="fa fa-fw fa-warning"></i>'.$this->session->flashdata('error').'</p>';?>

    <div class="box">
      <div class="box-header">
        <h3 class="box-title" style="display:block">Admin List <a class="btn btn-primary btn-sm pull-right" href="<?=base_url()?>admin/admin_manage/create/">Add New</a></h3>
      </div>
      <div class="box-body">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Username</th>
              <th>Role</th>
              <th>Last Login</th>
              <th>Active</th>
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($dataArr['adminArr'] as $value):?>
            <tr>
              <td><?=$value['name']?></td>
              <td><?=$value['username']?></td>
              <td><?=get_anydata('arg_admin_type','title',$value['role'])?></td>
              <td><?=$value['last_login']!=''?unix_to_human($value['last_login']):'---'?></td>
              <td>
                <?=$value['active']=='0'?'No':'Yes'?>
                <?php if(($value['id'] != '1') OR ($value['id'] != $_SESSION['admin_id'])):?>
                <a href="<?=base_url()?>admin/admin_manage/change_status/?id=<?=$value['id']?>&val=<?=$value['active']=='0'?'1':'0'?>"><i class="fa fa-refresh fa-fw"></i></a>
                <?php endif?>
              </td>
              <td class="text-right">

                <?php if(($value['id'] != '1') and ($value['id'] != $_SESSION['admin_id'])):?>
                <a title="Edit" class="btn btn-success btn-xs" href="<?=base_url()?>admin/admin_manage/edit/?id=<?=$value['id']?>"><i class="fa fa-pencil fa-fw"></i></a>
                <?php endif?>

                <?php if($value['id'] != '1'):?>
                <a title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Once deleted it cannot be restored. Are you sure you want to delete this?')" href="<?=base_url()?>admin/admin_manage/delete/?id=<?=$value['id']?>"><i class="fa fa-close fa-fw"></i></a>
                <?php endif?>
              </td>
            </tr>
            <?php endforeach?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?=base_url()?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(document).ready(function() {
    $('#listtable').DataTable()
  });
</script>
