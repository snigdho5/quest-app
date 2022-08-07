
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    View Trendsetter
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?=base_url()?>admin/trendsetter/">Trendsetter</a></li>
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
                <label class="control-label col-sm-2">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['trendsetterArr'][0]['name']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Email</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['trendsetterArr'][0]['email']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Phone</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['trendsetterArr'][0]['phone']?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Profession</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['trendsetterArr'][0]['profession']?>">
                </div>
              </div>
              <div class="form-group"> 
                <label class="control-label col-sm-2">Category</label>
                <div class="col-sm-10">
                  <?php if($dataArr['trendsetterArr'][0]['category'] == 'all'){ ?>
                  <input type="text" class="form-control" readonly value="lifestyle,beauty,food,fitness,mother&child care,kids,movies,">
                  <?php } 
                  else{?>
                  <input type="text" class="form-control" readonly value="<?=$dataArr['trendsetterArr'][0]['category']?>">
                  <?php }?>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Experience</label>
                <div class="col-sm-10">
                  <?php if($dataArr['trendsetterArr'][0]['experience'] == '1year'){ ?>
                  <input type="text" class="form-control" readonly value="6 months – 1 year">
                  <?php } ?>
                  <?php if($dataArr['trendsetterArr'][0]['experience'] == '2year'){ ?>
                  <input type="text" class="form-control" readonly value="1 – 2 years">
                  <?php } ?>
                  <?php if($dataArr['trendsetterArr'][0]['experience'] == '3year'){ ?>
                  <input type="text" class="form-control" readonly value="2 – 3 years">
                  <?php } ?>
                  <?php if($dataArr['trendsetterArr'][0]['experience'] == '4year'){ ?>
                  <input type="text" class="form-control" readonly value="3 years or more">
                  <?php } ?>
                </div>
              </div>
              <div class="form-group"> 
                <label class="control-label col-sm-2">PREFERRED SOCIAL MEDIA PAGES</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['trendsetterArr'][0]['preffered_social_media']?>">
                </div>
              </div>
              <div class="form-group"> 
                <label class="control-label col-sm-2">HOW OFTEN WOULD YOU LIKE TO CURATE CONTENT</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['trendsetterArr'][0]['curate_content']?>">
                </div>
              </div>
              <div class="form-group"> 
                <label class="control-label col-sm-2">OTHER BRANDS THAT HE/SHE ARE CURRENTLY ENDORSING</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['trendsetterArr'][0]['endorse_name']?>">
                </div>
              </div>
              <div class="form-group"> 
                <label class="control-label col-sm-2">LINKS TO HIS/HER SOCIAL HANDLES</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['trendsetterArr'][0]['social_links']?>">
                </div>
              </div>
              <div class="form-group"> 
                <label class="control-label col-sm-2">HIS/HER MOST FASCINATING PIECE OF WORK</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=$dataArr['trendsetterArr'][0]['facinating_piece']?>">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-2">About</label>
                <div class="col-sm-10">
                  <textarea class="form-control" rows="5" readonly><?=$dataArr['trendsetterArr'][0]['about']?></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2">Created</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" readonly value="<?=unix_to_human($dataArr['trendsetterArr'][0]['created'])?>">
                </div>
              </div>
            </form>
          </div>

        </div>
        <a class="btn btn-primary pull-right" href="<?=base_url()?>admin/trendsetter/">Back</a>
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
