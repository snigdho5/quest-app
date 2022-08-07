<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net/js/Buttons-1.4.2/css/buttons.bootstrap.min.css"/>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Trendsetter
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">Trendsetter</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <?php if($this->session->flashdata('success')) echo '<p class="alert alert-success"><i class="fa fa-fw fa-check"></i>'.$this->session->flashdata('success').'</p>';?>
    <?php if($this->session->flashdata('error')) echo '<p class="alert alert-danger"><i class="fa fa-fw fa-warning"></i>'.$this->session->flashdata('error').'</p>';?>

    <div class="box">
      <div class="box-header">
        <h3 class="box-title" style="display:block">Trendsetter List</h3>
      </div>
      <div class="box-body ">
        <table id="listtable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Profession</th>
              <th>Category</th>
              <th>Experience</th>
              <th>Preferred Social Media Pages</th>
              <th>How Often Would You Like To Curate Content</th>
              <th>Other Brands That He/she Are Currently Endorsing</th>
              <th>Links To His/her Social Handles</th>
              <th>His/her Most Fascinating Piece Of Work</th>
              <th>About</th>
              <th>Created</th>
              <th class="text-right">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($dataArr['trendsetterArr'] as $value):?>
            <tr>
              <td><?=$value['name']?></td>
              <td><?=$value['email']?></td>
              <td><?=$value['phone']?></td>
              <td><?=$value['profession']?></td>
              <td>
                <?php if($value['category'] == 'all'){ ?>
                lifestyle,beauty,food,fitness,mother&child care,kids,movies
                <?php }
                else{?>
                <?=$value['category']?>
                <?php }?>
              </td>
              <td>
                <?php if($value['experience'] == '1year'){ ?>
                6 months – 1 year
                <?php } ?>
                <?php if($value['experience'] == '2year'){ ?>
                1 – 2 years
                <?php } ?>
                <?php if($value['experience'] == '3year'){ ?>
                2 – 3 years
                <?php } ?>
                <?php if($value['experience'] == '4year'){ ?>
                3 years or more
                <?php } ?>
              </td>
              <td><?=$value['preffered_social_media']?></td>
              <td><?=$value['curate_content']?></td>
              <td><?=$value['endorse_name']?></td>
              <td><?=$value['social_links']?></td>
              <td><?=$value['facinating_piece']?></td>
              <td><?=$value['about']?></td>
              <td><?=unix_to_human($value['created'])?></td>
              <td class="text-right">
                <a title="View" class="btn btn-default btn-xs" href="<?=base_url()?>admin/trendsetter/view/?id=<?=$value['id']?>"><i class="fa fa-eye fa-fw"></i></a>
                <a title="Delete" class="btn btn-danger btn-xs" onclick="return confirm('Once deleted it cannot be restored. Are you sure you want to delete this?')" href="<?=base_url()?>admin/trendsetter/delete/?id=<?=$value['id']?>"><i class="fa fa-close fa-fw"></i></a>
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

<script src="<?=base_url()?>bower_components/datatables.net/js/JSZip-2.5.0/jszip.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net/js/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net/js/Buttons-1.4.2/js/buttons.bootstrap.min.js"></script>
<script src="<?=base_url()?>bower_components/datatables.net/js/Buttons-1.4.2/js/buttons.html5.min.js"></script>

<script>
  $(document).ready(function() {
    $('#listtable').DataTable({
      columnDefs: [
          {
              "targets": [ 3,5,6,7,8,9,10,11 ],
              "visible": false
          }
      ],
      dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      buttons: [
        {
          'filename':'Tredsetter_reg_<?=date('Y-m-d')?>',
          'extend':'excelHtml5',
          'exportOptions':{
            'columns':':not(:last-child)'
          },
          'text':'<i class="fa fa-download fa-fw"></i> Download'
        },
        {
          'filename':'Tredsetter_reg_<?=date('Y-m-d')?>',
          'extend':'excelHtml5',
          'exportOptions':{
            'columns':':not(:last-child)',
            'modifier': {
              'search': 'none',
              'order': 'applied'
            }
          },
          'text':'<i class="fa fa-download fa-fw"></i> Download All'
        },
      ]
    })
  });

</script>
