<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Admin Panel Navigation
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Admin Panel Navigation</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <?php if($this->session->flashdata('success')) echo '<p class="alert alert-success"><i class="fa fa-fw fa-check"></i>'.$this->session->flashdata('success').'</p>';?>
    <?php if($this->session->flashdata('error')) echo '<p class="alert alert-danger"><i class="fa fa-fw fa-warning"></i>'.$this->session->flashdata('error').'</p>';?>

    <div class="box">
      <div class="box-header">
        <h3 class="box-title" style="display:block">Module List <a class="btn btn-primary btn-sm pull-right" href="<?=base_url()?>admin/admin_module/create/">Add New</a></h3>
      </div>
      <div class="box-body">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Module</th>
              <th>Parent</th>
              <th>Show Before</th>
              <th>Link</th>
              <th>Published</th>
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($dataArr['modArr'] as $value):?>
            <tr>
              <td><i class="fa fa-fw fa-<?=$value['parent_id']=='0'?$value['icon']:get_anydata('arg_admin_module','icon',$value['parent_id'])?>"></i> <?=$value['parent_id']=='0'?$value['module']:get_anydata('arg_admin_module','module',$value['parent_id']).' >> '.$value['module']?></td>
              <td><?=get_anydata('arg_admin_module','module',$value['parent_id'])?></td>
              <td><?=get_anydata('arg_admin_module','module',$value['show_before'])?></td>
              <td><?=base_url()?>admin/<?=$value['link']?></td>
              <td><?=$value['active']=='0'?'No':'Yes'?> <a onclick="return confirm('Are you sure you want to change this status ?')" href="<?=base_url()?>admin/admin_module/change_status/?id=<?=$value['id']?>&val=<?=$value['active']=='0'?'1':'0'?>"><i class="fa fa-refresh fa-fw"></i></a></td>
              <td class="text-right">
                <a title="Edit" class="btn btn-success btn-xs" href="<?=base_url()?>admin/admin_module/edit/?id=<?=$value['id']?>"><i class="fa fa-pencil fa-fw"></i></a>
                <a title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Once deleted it cannot be restored. Are you sure you want to delete this?')" href="<?=base_url()?>admin/admin_module/delete/?id=<?=$value['id']?>"><i class="fa fa-close fa-fw"></i></a>
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
