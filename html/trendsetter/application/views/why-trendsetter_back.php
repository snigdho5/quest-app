<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name='title' content="Quest Trendsetter" />
    <link rel="icon" href="<?=base_url()?>images/favpng.png" type="image" sizes="16x16">
    <title>Quest Trendsetter | Sign Up</title>
    <link rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,700,900|Nunito:300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url()?>plugins/fullpage/jquery.fullpage.min.css">
    <link rel="stylesheet" href="<?=base_url()?>css/style.css">
</head>

<body>
	<div id="header">
		<img src="<?=base_url()?>images/right_bg.png" alt="" class="img-fluid right_bg">
		<a href="<?=base_url()?>"><img src="<?=base_url()?>images/logo.png" alt="" class="img-fluid logo"></a>
	</div>
	<div id="footer">
		<!-- <img src="images/left_bg.png" alt="" class="img-fluid left_bg"> -->
		<div class="boxss">
			<div class="f_box">
				<a href="<?=base_url()?>who-trendsetter/" class="text-uppercase">who is a trendsetter?</a>
			</div>
		</div>
		<div class="f_last">
			<span class="mb-0">© 2019 Quest properties India Ltd. All rights reserved <small>b</small></span>
		</div>
	</div>
	<div id="myContainer" class="innergap">
		<div class="section fp-scrollable">
			<div class="row d-flex justify-content-center">
				<div class="col-lg-5 col-md-10 col-10 pt-3">
					<span class="textspan text-uppercase">
						why be a trendsetter?
					</span>
					<p class="color1 mt-4 h3">Pamper yourself with these exclusive perks at Quest</p>
					<div class="row mt-lg-5 mt-md-4 mt-3">
						<div class="col-md-6 mt-lg-3 mt-md-4">
							<div class="media">
							  <div class="media-body">
							    <h2 class="text2 text-left w-100 mb-0 mt-0">Upto 15%</h2>
							    <p class="text-white text-left w-100">discount on in-house restaurants</p>
							  </div>
							</div>
						</div>
						<div class="col-md-6 mt-lg-3 mt-md-4">
							<div class="media">
							  <div class="media-body">
							    <h2 class="text2 text-left w-100 mb-0 mt-0">Flat 10%</h2>
							    <p class="text-white text-left w-100">discount on in-house brands</p>
							  </div>
							</div>
						</div>
						<div class="col-md-6 mt-lg-3 mt-md-4">
							<div class="media">
							  <img src="<?=base_url()?>images/parking.png" class="align-self-start mr-2 parking" alt="...">
							  <div class="media-body">
							    <h2 class="mt-0 text3 mb-0 text-left">Valet parking</h2>
							    <p class="text-white text-left">when you arrive at Quest</p>
							  </div>
							</div>
						</div>
						<div class="col-md-6 mt-lg-3 mt-md-4">
							<div class="media">
							  <img src="<?=base_url()?>images/inox.png" class="align-self-start mr-2 inox" alt="...">
							  <div class="media-body">
							    <p class="text-white text-left">Concessions on morning shows at Inox</p>
							  </div>
							</div>
						</div>
						<div class="col-md-12 mt-lg-3 mt-md-4 mt-2 d-md-flex justify-content-center">
							<div class="media">
							  <img src="<?=base_url()?>images/offers.png" class="align-self-start mr-2 offers" alt="...">
							  <div class="media-body">
							    <p class="text-white text-left">Exclusive offers at The Loft</p>
							  </div>
							</div>
						</div>
					</div>
					<a href="<?=base_url()?>?id=signup" class="btn text-uppercase mt-4 rounded-0 morebutton mb-4">Sign Up Now!</a>
				</div>
			</div>
		</div>
	</div>
	

</body>


<script type="text/javascript" src="<?=base_url()?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>plugins/sweetalert-master/sweetalert.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>plugins/fullpage/scrolloverflow.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>plugins/fullpage/jquery.fullpage.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>plugins/fullpage/jquery.fullpage.extensions.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
<script type="text/javascript">
	var slideNo = 0;
	$('#myContainer').fullpage({
		paddingTop: '0',
        paddingBottom: ($('#footer').height()-$('.left_bg').height())+'px',
		slidesNavigation: false,
		scrollHorizontally: true,
		//loopHorizontal: false,
		controlArrows: false,
		scrollOverflow: false,
		scrollHorizontallyKey: 'YWx2YXJvdHJpZ28uY29tX01mU2MyTnliMnhzU0c5eWFYcHZiblJoYkd4NVNRcg==',
		afterSlideLoad: function(section, origin, destination, direction){
			console.log({
				section: section,
				origin: origin,
				destination: destination,
				direction: direction
			});
			$.fn.fullpage.reBuild(); 
			addScroll();
		},
		onSlideLeave: function(section, origin, destination, direction){
			
		},
		afterRender: function(){

			addScroll();
		},
	});

  
  $( document ).ready(function() {
    addScroll();
  }); 

  function addScroll()
  {
  	$('.fp-scrollable').slimScroll({
	    alwaysVisible: true,
	    color: '#ddd',
	    size: '10px',
	    height: '100%',
	    allowPageScroll: true,
	});
  }

  $( window ).load(function() {
	 var rightbox = $('.f_box').height();
	 var f_last =  $('.f_last').height();
	 var totalHeight = rightbox + f_last;
	 $('body').css('padding-bottom',totalHeight+'px');
  });

$(function($) {
    $.ajaxSetup({
        data: {
            <?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    });
});
</script>

</html>