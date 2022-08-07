<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Website Navigation
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Navigation</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <?php if($this->session->flashdata('success')) echo '<p class="alert alert-success"><i class="fa fa-fw fa-check"></i>'.$this->session->flashdata('success').'</p>';?>
    <?php if($this->session->flashdata('error')) echo '<p class="alert alert-danger"><i class="fa fa-fw fa-warning"></i>'.$this->session->flashdata('error').'</p>';?>

    <div class="box">
      <div class="box-header">
        <h3 class="box-title" style="display:block">Menu List <a class="btn btn-primary btn-sm pull-right" href="<?=base_url()?>admin/navigation/create/">Add New</a></h3>
      </div>
      <div class="box-body">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Menu</th>
              <th>Parent Menu</th>
              <th>Type</th>
              <th>Created</th>
              <th>Modified</th>
              <th>Published</th>
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($dataArr['navArr'] as $value):?>
            <tr>
              <td>
                <?php if($value['parent_id']=='0'):?>
                <form action="" method="post" style="display: inline-block; margin-right: 3px">
                  <input type="hidden" name="id" value="<?=$value['id']?>">
                  <select name="o" onchange="this.form.submit()">
                    <?php for ($i=1; $i <= count_rows('arg_navigation',array('parent_id'=>'0')); $i++){?>
                    <option value="<?=$i?>" <?=$value['priority']==$i?'selected':''?>><?=$i?></option>
                    <?php } ?>
                  </select>
                </form>
                <?php endif?>
                <?=$value['menu']?>
              </td>
              <td><?=get_anydata('arg_navigation','menu',$value['parent_id'])?></td>
              <td><?=$value['parent_id']!='0'?'Sub-Menu':($value['mega']=='0'?'Normal Menu':'Mega-Menu')?></td>
              <td><?=unix_to_human($value['created'])?></td>
              <td><?=unix_to_human($value['modified'])?></td>
              <td><?=$value['active']=='0'?'No':'Yes'?> <a onclick="return confirm('Are you sure you want to change this status ?')" href="<?=base_url()?>admin/navigation/change_status/?id=<?=$value['id']?>&val=<?=$value['active']=='0'?'1':'0'?>"><i class="fa fa-refresh fa-fw"></i></a></td>
              <td class="text-right">
                <a title="View" class="btn btn-default btn-xs" href="<?=base_url()?>admin/navigation/view/?id=<?=$value['id']?>"><i class="fa fa-eye fa-fw"></i></a>
                <a title="Edit" class="btn btn-success btn-xs" href="<?=base_url()?>admin/navigation/edit/?id=<?=$value['id']?>"><i class="fa fa-pencil fa-fw"></i></a>
                <a title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Once deleted it cannot be restored. Are you sure you want to delete this?')" href="<?=base_url()?>admin/navigation/delete/?id=<?=$value['id']?>"><i class="fa fa-close fa-fw"></i></a>
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
    $('#listtable').DataTable({
      "order": [[ 1, 'asc' ]],
      "displayLength": 100,
      "drawCallback": function ( settings ) {
          var api = this.api();
          var rows = api.rows( {page:'current'} ).nodes();
          var last=null;

          api.column(1, {page:'current'} ).data().each( function ( group, i ) {
              if ( last !== group ) {
                  $(rows).eq( i ).before(
                      '<tr class="group bg-gray"><td colspan="7">'+(group==''?'Parent Menu':'Sub Menu of <b>'+group+'</b>')+'</td></tr>'
                  );

                  last = group;
              }
          } );
      }
    })
  });
    
</script>
