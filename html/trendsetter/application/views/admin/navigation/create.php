<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

  <!-- Content Header (Page header) -->

  <section class="content-header">

    <h1>

    New Navigation

    </h1>

    <ol class="breadcrumb">

      <li><a href="<?=base_url()?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>

      <li><a href="<?=base_url()?>admin/navigation/">Navigation</a></li>

      <li class="active">Add New</li>

    </ol>

  </section>

  <!-- Main content -->

  <section class="content">

    

    <div class="box">

      <form class="form-horizontal" action="" method="post">

        <div class="box-body">

          <div class="form-group">

            <label class="control-label col-sm-2">Menu*</label>

            <div class="col-sm-10">

              <input type="text" class="form-control" placeholder="Enter menu" name="menu" required value="<?=set_value('menu')?>">

              <small><i class="fa fa-info-circle fa-fw"></i> Enter "<b>_slider</b>" for no heading.</small>

              <?=form_error('menu', '<p class="text-danger">', '</p>')?>  

            </div>            

          </div>

          

          <div class="form-group">

            <label class="control-label col-sm-2">Link*</label>

            <div class="col-sm-10">

              <input type="text" class="form-control" placeholder="Enter link" name="link" required value="<?=set_value('link')?>">
              <small><i class="fa fa-info-circle fa-fw"></i> Enter link without website name and add slash (/) at last.</small>

              <?=form_error('link', '<p class="text-danger">', '</p>')?>  

            </div>            

          </div>

          <div class="form-group">

            <label class="control-label col-sm-2">Parent Menu<br><small>(optional)</small></label>

            <div class="col-sm-10">

              <select class="form-control" name="parent_id">

                <option value="" selected disabled>Select Parent Menu</option>

                <?php foreach($dataArr['navArr'] as $value):if($value['parent_id']=='0'){?>

                <option data-mega="<?=$value['mega']?>" value="<?=$value['id']?>" <?=set_value('parent_id')==$value['id']?'selected':''?>><?=$value['menu']?> (<?=$value['mega']=='0'?'Normal menu':'Megamenu'?>)</option>

                <?php }endforeach?>

              </select>

              <?=form_error('parent_id', '<p class="text-danger">', '</p>')?>  

            </div>            

          </div>

          

          <div id="parentdetails">



            <div class="form-group">

              <label class="control-label col-sm-2">Menu Type*</label>

              <div class="col-sm-10">

                <select class="form-control" name="mega" required>

                  <option value="1">Full-Width Megamenu</option>

                  <option value="2">Half-Width Megamenu</option>

                  <option value="3">Custom-Width Megamenu</option>

                  <option value="0" selected>Normal</option>

                </select>

                <?=form_error('show_recipe', '<p class="text-danger">', '</p>')?>   

              </div>            

            </div>

            

            <div class="form-group" id="varwidth" style="display: none">

              <label class="control-label col-sm-2">Dropdown Width*</label>

              <div class="col-sm-10">

                <div class="input-group">

                  <input type="number" class="form-control" placeholder="Enter width" name="width" required value="<?=set_value('width')!=''?set_value('width'):0?>">

                  <span class="input-group-addon">%</span>

                </div>

                <?=form_error('width', '<p class="text-danger">', '</p>')?>  

              </div>            

            </div>

          </div>



          <div id="childdetails" style="display: none">

            <div class="form-group">

              <label class="control-label col-sm-2">Class</label>

              <div class="col-sm-10">

                <input type="text" class="form-control" placeholder="Enter class" name="class" value="<?=set_value('class')?>">

                <small><i class="fa fa-info-circle fa-fw"></i> Separate multiple class with space. <b>Eg:</b> col-lg-3 col-md-3 col-xs-12 link-list</small>



                <?=form_error('class', '<p class="text-danger">', '</p>')?>  

              </div>            

            </div>

            <div class="form-group">

              <label class="control-label col-sm-2">Content</label>

              <div class="col-sm-10">

                <textarea id="content" class="form-control" name="content" rows="10"><?=set_value('content')?></textarea>

                <small><i class="fa fa-info-circle fa-fw"></i> Add <b>button_megamenu</b> class in anchor tag for button.</small><br>

                <small><i class="fa fa-info-circle fa-fw"></i> Add "<b>[base_url]</b>" before any inernal link.</small>

                <?=form_error('content', '<p class="text-danger">', '</p>')?>  

              </div>            

            </div>

          </div>

          <div class="form-group">
            <label class="control-label col-sm-2">Post Time*</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Enter date time" name="post_time" required value="<?=set_value('post_time')?>">
              <?=form_error('post_time', '<p class="text-danger">', '</p>')?>
            </div>
          </div>
          <div class="form-group">

            <label class="control-label col-sm-2">Active*</label>

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

          <a class="btn btn-primary" href="<?=base_url()?>admin/navigation/">Back</a>

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

    CKEDITOR.replace('content');

    

  });



  $('[name="mega"]').change(function(event) {

    if($(this).val() == '3') $('#varwidth').show().find('input').val( 100);

    else $('#varwidth').hide().find('input').val(0);

  });



  $('[name="parent_id"]').change(function(event) {

    if($(this).find('option:selected').data('mega') == '0') {

      $('#childdetails').hide()

    }

    else{

      $('#childdetails').show()

    }

    $('#parentdetails').hide()

  });
  $('[name="post_time"]').datetimepicker({format: 'YYYY-MM-DD hh:mm A'});
</script>

