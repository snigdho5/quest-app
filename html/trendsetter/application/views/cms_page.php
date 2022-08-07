<div class="clearfix"></div>
<div class="innerbanner">
  <img src="<?=base_url()?><?=$pageData['image']==''?'images/default_back.jpg':'uploads/cms/actual/'.$pageData['image']?>" alt="" class="img-responsive partnerbg" />
  <div class="innerbannerbox">
    <h2><?=$pageData['title']?></h2>
    <img src="<?=base_url()?>images/innerline.png" alt="" class="innerline">
    <div class="clearfix"></div>
  </div>
  <div class="clearfix"></div>
</div>
<div class="breadcrumbbox">
  <div class="container">
    <!-- <div class="pull-left">
      <p><a href="<?=base_url()?>">Home</a> | <span><?=$pageData['title']?></span></p>
    </div>
    <div class="pull-right">

    </div> -->
  </div>
</div>
<br>
<section>
  <div class="container">
    <?php
    $page_data = explode('[---]',$pageData['content']);
    if(trim($page_data[0])!='<p>') echo htmlspecialchars_decode(str_replace('[base_url]',base_url(),$page_data[0]));

    if(isset($page_data[1])) if(isset($moduleData)){

      $this->load->view($module,array('moduleData'=>$moduleData));
    }
    if(isset($page_data[1])) echo htmlspecialchars_decode(str_replace('[base_url]',base_url(),$page_data[1]));
    ?>
  </div>
</section>

<br>