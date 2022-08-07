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
    <style>
    	body{
    		max-height: 100vh;
    		padding-top: 50px;
    	}
    	#header{
    		position: fixed;
    		top: 0;
    		left: 0;
    		right: 0;
    	}
    	@media screen and (max-width: 575px) {
    		body{
    		padding-top: 0px;
    	}
    	}
    </style>


    <!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-N2VGPVS');</script>
	<!-- End Google Tag Manager -->
</head>

<body>
	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N2VGPVS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<div id="header">
		<img src="<?=base_url()?>images/right_bg.png" alt="" class="img-fluid right_bg">
		<a href="<?=base_url()?>"><img src="<?=base_url()?>images/logo.png" alt="" class="img-fluid logo"></a>
	</div>
	<div id="footer">
		<!-- <img src="images/left_bg.png" alt="" class="img-fluid left_bg"> -->
		<div class="boxss">
			<div class="f_box">
				<a href="<?=base_url()?>why-trendsetter/" class="text-uppercase">Why be a Trendsetter?</a>
			</div>
		</div>
		<div class="f_last">
			<span class="mb-0">© 2019 Quest properties India Ltd. All rights reserved <small>b</small></span>
		</div>
	</div>
	<div class="footerleftbg">
		<img src="<?=base_url()?>images/left_bg.png" class="img-fluid" alt="">
	</div>
	<div class="innerbgcont">
		<div class="container main_container" style="padding-bottom: 100px;">
			<div class="row d-flex justify-content-center">
				<div class="col-xl-6 col-lg-7 col-md-10 col-10">
					<span class="textspan text-uppercase">
						who is a trendsetter?
					</span>
					<p class="color1 mt-lg-4 mt-md-4 mt-3 h3">Looking to take your social media and online presence game to the next level?</p>
					<img src="<?=base_url()?>images/textimg.png" alt="" class="img-fluid pt-lg-4 pt-md-4 pt-3 pb-lg-4 pb-md-4 pb-3">
					<p class="text-white mb-md-2 mb-0">To be a Quest Trendsetter, you should have a minimum of 5-10K following on each of the social media platforms that you are present on. Your monthly post reach should be above the 50K mark while your average engagement rate should be at least 2%. What will make your case stronger to become a Quest Trendsetter is if you carry 2 years of experience are active weekly, if not more.<br><br>Upon meeting the above parameters, you can sign up for the Quest Trendsetter program and have a chance to become a part of an exclusive family. As part of the program, you will be required to promote the brands at Quest on your social platforms and do what you do best! You are then entitled to exclusive deals that Quest has to offer, while you continue to shoulder the responsibility to hold Quest in high regard.</p>
					<div class="col-md-12 text-center">
						<a href="<?=base_url()?>?id=signup" class="btn text-uppercase mt-4 rounded-0 morebutton">Sign Up Now!</a>
					</div>
					<p></p>
					<p></p>
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


$(function($) {
    $.ajaxSetup({
        data: {
            <?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    });
});
</script>

</html>