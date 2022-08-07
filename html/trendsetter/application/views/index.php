<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name='title' content="Quest Trendsetter"/>
    <link rel="icon" href="images/favpng.png" type="image" sizes="16x16">
    <title>Quest Trendsetter | Sign Up</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,700,900|Nunito:300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="plugins/fullpage/jquery.fullpage.min.css">
    <link rel="stylesheet" href="css/style.css?<?=time()?>">

    <!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-N2VGPVS');</script>
	<!-- End Google Tag Manager -->

	<!-- <style>
		.table-trendsetter table, th, td{
		  border: 1px solid black;
		}
	</style> -->

	<style>
		label.error{display: none !important}
	</style>
</head>

<body>
	<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N2VGPVS"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<div id="header">
		<img src="images/right_bg.png" alt="" class="img-fluid right_bg">
		<img src="images/logo.png" alt="" class="img-fluid logo" id="logo" style="display: none;">
	</div>
	<div id="footer">
		<!-- <img src="images/left_bg.png" alt="" class="img-fluid left_bg"> -->
		<div class="boxs">
			<div class="leftbox">
				<a href="<?=base_url()?>who-trendsetter/" class="text-uppercase test">who is a trendsetter?</a>
			</div>
			<div class="rightbox">
				<a href="<?=base_url()?>why-trendsetter/" class="text-uppercase">Why be a Quest Trendsetter?</a>
			</div>
		</div>
		<div class="f_last">
			<span class="mb-0">© 2019 Quest properties India Ltd. All rights reserved <a href="#"><small>b</small></a></span>
		</div>
	</div>
	<div id="myContainer">
		<div class="section fp-scrollable">
			<form class="formbg" action="" method="POST" id="trendsetter_form">
				<div class="slide" id="slide0" data-anchor="slide1">
					<div class="row d-flex justify-content-center">
						<div class="col-lg-5 col-md-10 col-10">
							<img src="images/logo2.png" alt="" class="logo2 img-fluid mb-lg-5 mb-md-5 mb-3">
							<p class="color1 mt-3 h3">Do followers love you on social?</p>
							<p class="text-white mt-3">Quest is looking for social engagers like you.<br> Sign up for a fantastic experience, now!</p>
							<button type="button" id="i_m_in" class="btn text-uppercase mt-lg-4 mt-md-4 mt-3 rounded-0 morebutton mb-lg-4 mb-md-4 mb-0" onclick="Check()">i’m in <i class="fa fa-angle-right" aria-hidden="true"></i></button><br>
							<!-- <a href="#" class="text-uppercase morelink">Know More</a> -->
						</div>
					</div>
				</div>
				<div class="slide position-relative" id="slide1" data-anchor="slide1" style="display: none;">
					<div class="row d-flex justify-content-center">
						<div class="col-xl-5 col-lg-7 col-md-10 col-10">
								<div class="input-group mb-lg-2 mb-md-2 mb-1">
							        <div class="input-group-prepend rounded-0">
							          <div class="input-group-text rounded-0 border-0 pl-0"><img src="images/hi_icon.png" alt="" class="img-fluid hi_icon"></div>
							        </div>
							        <input type="text" name="name" class="form-control rounded-0" id="inlineFormInputGroup" placeholder="Your name please*" required>
						      	</div>
						      	<div class="row">
						      		<div class="col-md-6 mt-lg-3 mt-md-3 mt-1">
						      			<div class="form-group">
										    <input type="email" name="email" class="form-control rounded-0" id="Emai1" placeholder="Enter email*" required>
										 </div>
						      		</div>
						      		<div class="col-md-6 mt-lg-3 mt-md-3 mt-1">
						      			<div class="form-group">
										    <input type="tel" name="phone" class="form-control rounded-0" id="number" placeholder="Enter 10 digit mobile number*" required>
										 </div>
						      		</div>
						      	</div>
								<p class="color2 mt-lg-5 mt-md-4 mt-3 h3">Are you a</p>
								<div class="row">
									<div class="col-md-4 col-4 mt-3">
										<label class="box_height d-flex align-items-center justify-content-center" for="blogger">
											<img src="images/bloggericon.png" alt="" class="img-fluid" for="blogger">
										</label>
										<div class="form-group mt-2">
										    <div class="form-check">
										      <input class="form-check-input" type="radio" name="profession" id="blogger" value="blogger">
										      <label class="form-check-label text-white" for="blogger">
										        Blogger
										      </label>
										    </div>
										</div>
									</div>
									<div class="col-md-4 col-4 mt-3">
										<label class="box_height d-flex align-items-center justify-content-center" for="vlogger">
											<img src="images/vloggericon.png" alt="" class="img-fluid" for="vlogger">
										</label>
										<div class="form-group mt-2">
										    <div class="form-check">
										      <input class="form-check-input" type="radio" name="profession" value="vlogger" id="vlogger">
										      <label class="form-check-label text-white" for="vlogger">
										        Vlogger
										      </label>
										    </div>
										</div>
									</div>
									<div class="col-md-4 col-4 mt-3">
										<div class="box_height d-flex align-items-center justify-content-center">
											<label class="h4 text-white mb-0" for="both">Both</label>
										</div>
										<div class="form-group mt-2">
										    <div class="form-check">
										      <input class="form-check-input" type="radio" value="blogger,vlogger" name="profession" id="both">
										    </div>
										</div>
									</div>
								</div>
								<button type="button" id="user_contact_info" onclick="slideOneCheck()" class="btn text-uppercase mt-4 rounded-0 morebutton mb-lg-4 mb-md-4 mb-0">NEXT <i class="fa fa-angle-right" aria-hidden="true"></i></button><br>

						</div>
					</div>
					<div class="next" onclick="slideOneCheck()"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
				</div>
				<div class="slide position-relative" id="slide2" data-anchor="slide1" style="display: none;">
					<div class="row d-flex justify-content-center">
						<div class="col-xl-5 col-lg-7 col-md-10 col-10">
							<p class="color2 mt-lg-5 mt-md-5 mt-0 h3">Which of the category/categories do you specialise in?</p>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-4 mt-lg-3 mt-lg-4 mt-md-4 mt-3">
									<div onclick="$(this).parent().find('.form-check-label').click()" class="box_height d-flex align-items-center justify-content-center foo-check">
										<img src="images/lifestyle.png" alt="" class="img-fluid">
									</div>
									<div class="form-group mt-lg-2 mt-md-2 mt-0 mb-0">
									    <div class="form-check">
									      <input class="form-check-input foo-check" type="checkbox" name="category[]" value="lifestyle" id="gridCheck4">
									      <label class="form-check-label text-white" for="gridCheck4">
									        Lifestyle
									      </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-4 mt-lg-3 mt-lg-4 mt-md-4 mt-3">
									<div onclick="$(this).parent().find('.form-check-label').click()" class="box_height d-flex align-items-center justify-content-center foo-check">
										<img src="images/beauty.png" alt="" class="img-fluid">
									</div>
									<div class="form-group mt-lg-2 mt-md-2 mt-0 mb-0">
									    <div class="form-check">
									      <input class="form-check-input foo-check" type="checkbox" name="category[]" value="beauty" id="gridCheck5">
									      <label class="form-check-label text-white" for="gridCheck5">
									        Beauty
									      </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-4 mt-lg-3 mt-lg-4 mt-md-4 mt-3">
									<div onclick="$(this).parent().find('.form-check-label').click()" class="box_height d-flex align-items-center justify-content-center foo-check">
										<img src="images/food.png" alt="" class="img-fluid">
									</div>
									<div class="form-group mt-lg-2 mt-md-2 mt-0 mb-0">
									    <div class="form-check">
									      <input class="form-check-input foo-check" type="checkbox" name="category[]" value="food" id="gridCheck6">
									      <label class="form-check-label text-white" for="gridCheck6">
									        Food
									      </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-4 mt-lg-3 mt-lg-4 mt-md-4 mt-3">
									<div onclick="$(this).parent().find('.form-check-label').click()" class="box_height d-flex align-items-center justify-content-center foo-check">
										<img src="images/fitness.png" alt="" class="img-fluid">
									</div>
									<div class="form-group mt-lg-2 mt-md-2 mt-0 mb-0">
									    <div class="form-check">
									      <input class="form-check-input foo-check" type="checkbox" name="category[]" value="fitness" id="gridCheck7">
									      <label class="form-check-label text-white" for="gridCheck7">
									        Fitness
									      </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-4 mt-lg-3 mt-lg-4 mt-md-4 mt-3">
									<div onclick="$(this).parent().find('.form-check-label').click()" class="box_height d-flex align-items-center justify-content-center foo-check">
										<img src="images/mother.png" alt="" class="img-fluid">
									</div>
									<div class="form-group mt-lg-2 mt-md-2 mt-0 mb-0">
									    <div class="form-check">
									      <input class="form-check-input foo-check" type="checkbox" name="category[]" value="mother&child care" id="gridCheck8">
									      <label class="form-check-label text-white" for="gridCheck8">
									        Mother & Child Care
									      </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-4 mt-lg-3 mt-lg-4 mt-md-4 mt-3">
									<div onclick="$(this).parent().find('.form-check-label').click()" class="box_height d-flex align-items-center justify-content-center foo-check">
										<img src="images/kids.png" alt="" class="img-fluid">
									</div>
									<div class="form-group mt-lg-2 mt-md-2 mt-0 mb-0">
									    <div class="form-check">
									      <input class="form-check-input foo-check" type="checkbox" name="category[]" value="kids" id="gridCheck9">
									      <label class="form-check-label text-white" for="gridCheck9">
									        Kids
									      </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-4 mt-lg-3 mt-lg-4 mt-md-4 mt-3">
									<div onclick="$(this).parent().find('.form-check-label').click()" class="box_height d-flex align-items-center justify-content-center foo-check">
										<img src="images/movies.png" alt="" class="img-fluid">
									</div>
									<div class="form-group mt-lg-2 mt-md-2 mt-0 mb-0">
									    <div class="form-check">
									      <input class="form-check-input foo-check" type="checkbox" name="category[]" value="movies" id="gridCheck10">
									      <label class="form-check-label text-white" for="gridCheck10">
									        Movies
									      </label>
									    </div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-4 mt-lg-3 mt-lg-4 mt-md-4 mt-3">
									<div onclick="$(this).parent().find('.form-check-input').click()" class="box_height d-flex align-items-center justify-content-center">
										<h4 class="text-white mb-0">All of them</h4>
									</div>
									<div class="form-group mt-lg-2 mt-md-2 mt-0 mb-0">
									    <div class="form-check">
									      <input class="form-check-input" type="checkbox" name="category[]" value="" id="all">
									    </div>
									</div>
								</div>
							</div>
							<button onclick="slideTwoCheck()" id="user_specialise_categories" type="button" class="btn text-uppercase mt-4 rounded-0 morebutton">NEXT <i class="fa fa-angle-right" aria-hidden="true"></i></button><br>
						</div>
					</div>
					<div class="previous" onclick="previousSlideOne()"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
			        <div class="next" onclick="slideTwoCheck()"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
				</div>
				<div class="slide position-relative" id="slide3" data-anchor="slide1" style="display: none;">
					<div class="row d-flex justify-content-center">
						<div class="col-xl-5 col-lg-7 col-md-10 col-10">
							<p class="color2 mt-lg-5 mt-4 h3">For how many years have you been following your passion?</p>
							<div class="row right_checkbox mt-lg-5 mt-md-5 mt-3">
								<div class="col-md-6 col-8 offset-md-3 offset-2">
									<div class="form-group mt-2">
									    <div class="form-check">
									      <label class="form-check-label text-white" for="oneyear">
									        6 months – 1 year
									      </label>
									      <input class="form-check-input" type="radio" value="1year" name="experience" id="oneyear">
									    </div>
									</div>
									<div class="form-group mt-2">
									    <div class="form-check">
									      <label class="form-check-label text-white" for="twoyear">
									        1 – 2 years
									      </label>
									      <input class="form-check-input" type="radio" name="experience" value="2year" id="twoyear">
									    </div>
									</div>
									<div class="form-group mt-2">
									    <div class="form-check">
									      <label class="form-check-label text-white" for="threeyear">
									        2 – 3 years
									      </label>
									      <input class="form-check-input" type="radio" name="experience" value="3year" id="threeyear">
									    </div>
									</div>
									<div class="form-group mt-2">
									    <div class="form-check">
									      <label class="form-check-label text-white" for="fouryear">
									        3 years or more
									      </label>
									      <input class="form-check-input" type="radio" name="experience" value="4year" id="fouryear">
									    </div>
									</div>
								</div>
							</div>
							<button onclick="slideThreeCheck()" id="user_exprience" type="button" class="btn text-uppercase mt-4 rounded-0 morebutton">NEXT <i class="fa fa-angle-right" aria-hidden="true"></i></button><br>
						</div>
					</div>
					<div class="previous" onclick="previousSlideTwo()"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
			        <div class="next" onclick="slideThreeCheck()"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
				</div>
				<div class="slide position-relative" id="slide4" data-anchor="slide1" style="display: none;">
					<div class="row d-flex justify-content-center">
						<div class="col-xl-5 col-lg-7 col-md-10 col-10">
							<p class="color2 mt-5 h3">Your preferred Social Media pages</p>
							<div class="row right_checkbox mt-lg-5 mt-md-5 mt-3 d-flex justify-content-center">
								<div class="col-md-3 col-4">
									<div class="form-group mt-2 social_box">
									    <div class="form-check d-flex align-items-center">
									      <label class="form-check-label text-white" for="facebook">
									        <img src="images/facebook_icon.png" alt="" class="img-fluid socialicon">
									      </label>
									      <input class="form-check-input" type="checkbox" value="facebook" name="preffered_social_media[]" id="facebook">
									    </div>
									</div>
								</div>

								<div class="col-md-3 col-4">
									<div class="form-group mt-2 social_box">
									    <div class="form-check d-flex align-items-center">
									      <label class="form-check-label text-white" for="twitter">
									        <img src="images/twitter_icon.png" alt="" class="img-fluid socialicon">
									      </label>
									      <input class="form-check-input" type="checkbox" value="twitter" name="preffered_social_media[]" id="twitter">
									    </div>
									</div>
								</div>
							</div>

							<div class="row right_checkbox mt-3 d-flex justify-content-center">
								<div class="col-md-3 col-4">
									<div class="form-group mt-2 social_box">
									    <div class="form-check d-flex align-items-center">
									      <label class="form-check-label text-white" for="instagram">
									        <img src="images/instragram_icon.png" alt="" class="img-fluid socialicon">
									      </label>
									      <input class="form-check-input" type="checkbox" value="instagram" name="preffered_social_media[]" id="instagram">
									    </div>
									</div>
								</div>

								<div class="col-md-3 col-4">
									<div class="form-group mt-2 social_box">
									    <div class="form-check d-flex align-items-center">
									      <label class="form-check-label text-white" for="youtube">
									        <img src="images/youtube.png" alt="" class="img-fluid socialicon">
									      </label>
									      <input class="form-check-input" type="checkbox" value="youtube" name="preffered_social_media[]" id="youtube">
									    </div>
									</div>
								</div>
							</div>
							<!-- <p class="mt-3 textcolor">(Clicking on yes ‘others’ would open a dialogue box where they will type in the names of any other SM handles that they prefer)</p> -->
							<button onclick="slideFourCheck()" id="user_preffer_social_media" type="button" class="btn text-uppercase mt-4 rounded-0 morebutton">NEXT <i class="fa fa-angle-right" aria-hidden="true"></i></button><br>
						</div>
					</div>
					<div class="previous" onclick="previousSlideThree()"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
			        <div class="next" onclick="slideFourCheck()"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
				</div>
				<div class="slide position-relative" id="slide5" data-anchor="slide1" style="display: none;">
					<div class="row d-flex justify-content-center">
						<div class="col-xl-5 col-lg-7 col-md-10 col-10">
							<p class="color2 mt-5 mb-lg-0 mb-md-0 mb-3 h3">How often would you like to curate content for us?</p>
							<div class="row right_checkbox mt-lg-5 mt-md-4 mt-1 d-flex justify-content-center pb-lg-4 pb-md-4 pb-1">
								<div class="col-md-3 mr-lg-4">
									<div class="form-group mt-lg-2 mt-md-2 mt-0">
									    <div class="form-check d-flex align-items-center">
									      <label class="form-check-label text-white" for="gridCheck20">
									        Weekly
									      </label>
									      <input class="form-check-input" type="radio" value="weekly" name="curate_content" id="gridCheck20">
									    </div>
									</div>
								</div>
								<div class="col-lg-4 col-md-3 mr-lg-4">
									<div class="form-group mt-lg-2 mt-md-2 mt-0">
									    <div class="form-check d-flex align-items-center">
									      <label class="form-check-label text-white" for="gridCheck21">
									        Fortnightly
									      </label>
									      <input class="form-check-input" type="radio" value="fortnight" name="curate_content" id="gridCheck21">
									    </div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group mt-lg-2 mt-md-2 mt-0">
									    <div class="form-check d-flex align-items-center">
									      <label class="form-check-label text-white" for="gridCheck22">
									        Monthly
									      </label>
									      <input class="form-check-input" type="radio" value="monthly" name="curate_content" id="gridCheck22">
									    </div>
									</div>
								</div>
							</div>

							<p class="color2 mt-lg-5 mt-md-5 mt-3 h3 mb-lg-2 mb-0">Are there any other brands that you are currently endorsing? </p>
							<div class="row right_checkbox mt-lg-5 mt-3 d-flex justify-content-center">
								<div class="col-md-2 mr-lg-4">
									<div class="form-group mt-lg-2 mt-md-2 mt-0">
									    <div class="form-check d-flex align-items-center">
									      <label class="form-check-label text-white" for="gridCheck23">
									        Yes
									      </label>
									      <input class="form-check-input" type="radio" value="1" name="current_endorsing" id="gridCheck23">
									    </div>
									</div>
								</div>
								<div class="col-md-2 mr-lg-4">
									<div class="form-group mt-lg-2 mt-md-2 mt-0">
									    <div class="form-check d-flex align-items-center">
									      <label class="form-check-label text-white" for="gridCheck24">
									        No
									      </label>
									      <input class="form-check-input" type="radio" value="0" name="current_endorsing" id="gridCheck24">
									    </div>
									</div>
								</div>
							</div>
							<p class="color2 mb-lg-3 mb-md-3 mb-2 mt-3 h4 justify-content-center" id="brandLevel" style="display: none;">Please mention the name of the brand(s)</p>
                            <div class="form-group" id="brandInput" style="display: none;">
							    <input type="text" name="endorse_name" class="form-control rounded-0" id=""
							    placeholder="E.g. Brand One, Brand Two">
							</div>
							<button onclick="slideFiveCheck()" id="curate_content_interval" type="button" class="btn text-uppercase mt-lg-4 mt-md-4 mt-3 rounded-0 morebutton">NEXT <i class="fa fa-angle-right" aria-hidden="true"></i></button>
							<p></p>
						</div>
					</div>
					<div class="previous" onclick="previousSlideFour()"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
			        <div class="next" onclick="slideFiveCheck()"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
				</div>
				<div class="slide position-relative" id="slide6" data-anchor="slide1" style="display: none;">
					<div class="row d-flex justify-content-center">
						<div class="col-xl-5 col-lg-7 col-md-10 col-10">
							<p class="color2 mb-lg-3 mb-md-3 mb-2 h4 text-left">Please paste the links to your social handles</p>
							<div class="input-group mb-lg-2 mb-md-2 mb-1">
							    <input type="url" name="social_links[]" class="form-control rounded-0" id="" placeholder="" required>
							    <span class="input-group-btn"><button type="button" id="add_social_btn" onclick="add_social_links(this)" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i></button></span>
							</div>
							<p id="add_social_links"></p>
							<button onclick="slideSixCheck()" id="user_social_handles" type="button" class="btn text-uppercase mt-lg-4 mt-md-4 mt-3 rounded-0 morebutton">NEXT <i class="fa fa-angle-right" aria-hidden="true"></i></button><br>
						</div>
					</div>
					<div class="previous" onclick="previousSlideFive()"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
			        <div class="next" onclick="slideSixCheck()"><i class="fa fa-angle-right" aria-hidden="true"></i></div>
				</div>
				<div class="slide position-relative" id="slide7" data-anchor="slide1" style="display: none;">
					<div class="row d-flex justify-content-center">
						<div class="col-xl-5 col-lg-7 col-md-10 col-10">
								<p class="color2 mb-lg-3 mb-md-3 mb-2 mt-lg-4 mt-md-4 mt-3 h4 text-left">Please paste link to your most fascinating piece of work:</p>
								<div class="form-group">
								    <input type="url" name="facinating_piece" class="form-control rounded-0" id="" placeholder="" required>
								</div>
								<p class="color2 mb-lg-3 mb-md-3 mb-2 mt-lg-4 mt-md-4 mt-3 h4 text-left">Tell us why would you like to become a Quest Trendsetter?</p>
								<div class="form-group">
								    <textarea name="about" class="form-control rounded-0" id="" rows="3"></textarea>
								</div>
								<div class="input-group mb-lg-2 mb-md-2 mb-1">
									<?php
			                            $gcapData = $this->custom_captcha->generate('#000','#fff',110,38,10,100,'#555');
			                            $_SESSION['cap_career_text']=$gcapData['text'];
			                        ?>
							        <div class="input-group-prepend rounded-0">
							          <div class="input-group-btn rounded-0 border-0 pl-0" id="re_cap_career"><?=$gcapData['img']?></div>
							        </div>
							        <input name="captcha" type="text" class="form-control rounded-0" id="inlineFormInputGroup" placeholder="">
	                        		<span class="input-group-btn"><button type="button" class="btn btn-default rounded-0" onclick="change_captcha()"><i class="fa fa-fw fa-refresh"></i></button style="background-color: #dddddd;"></span>
						      	</div>
								<div class="form-check float-left">
							      <input class="form-check-input" type="checkbox" name="termsCondition" id="gridCheck30" >
							      <label class="form-check-label text-white" for="gridCheck30">
							        I agree to the <a href="javascript:void(0)" data-target="#am" data-toggle="modal">terms and conditions</a>
							      </label>
							    </div>
							<br>
							<button type="submit" id="final_submit" class="btn text-uppercase mt-4 rounded-0 morebutton">Sign Up Now!</button><br>
						</div>
					</div>
					<div class="previous" onclick="previousSlideSix()"><i class="fa fa-angle-left" aria-hidden="true"></i></div>
				</div>
				<div class="slide" id="slide8" data-anchor="slide1" style="display: none;">
					<div class="row d-flex justify-content-center">
						<div class="col-xl-5 col-lg-7 col-md-10 col-10">
							<a href="<?=base_url()?>"><img src="images/logo2.png" alt="" class="logo2 img-fluid mb-lg-5 mb-md-5 mb-3"></a>
							<p class="color1 text-uppercase mt-3 h4"><i class="fa fa-check fa-fw"></i>Sign up successful!</p>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
<div class="modal fade" id="am">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      	<h4 class="modal-title" style="color: #9b6228;">Terms and Conditions</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body" style="overflow-y: scroll; max-height: 60vh;">
        <div class="row">
          <h5 style="font-weight: bold; color: #d0ad68; font-family: inherit;padding-left: 13px;">Parameters For Trendsetters</h5>
          <p>
          	<table class="table table-bordered">
          		<thead>
          			<tr>
          			  <th>Particulars</th>
          			  <th>Criteria </th>
          			</tr>

          		</thead>
          		<tbody>
          			<tr>
	          			<td>Number Of Followers</td>
	          			<td>Minimum 5-10 K</td>
	          		</tr>
	          		<tr>
	          			<td>Monthly Post Reach </td>
	          			<td>50k</td>
	          		</tr>
	          		<tr>
	          			<td>Average Engagement Rate</td>
	          			<td>Minimum 2% & above</td>
	          		</tr>
	          		<tr>
	          			<td>Years of Experience</td>
	          			<td>Minimum 2 years</td>
	          		</tr>
	          		<tr>
	          			<td>Frequency of Engagement</td>
	          			<td>Active weekly</td>
	          		</tr>
          		</tbody>
          	</table>
          </p><br>
          <h5 style="font-weight: bold; color: #d0ad68; font-family: inherit;padding-left: 13px;">General T&C</h5>
          <ol style="text-align: left;font-family: inherit;"">
          <li>Quest Properties India Limited (“Quest”) launches the Trendsetter program which is essentially an influencer outreach program of the East India. The influencers on board will be called the Trendsetter and they would promote various brands inside the mall from different categories like Fashion, Food, Body care, Kids, Movies etc.</li>
          <li>Under the Quest Trendsetter Arrangement, you (herein after referred to as trendsetter) can’t associate with other malls or partake in similar programs that they run till the period of one year from the commencement of trendsetter arrangement (hereinafter referred to as the said period)</li>
          <li>All content though created, co-created and curated by the influencer will be the sole property of Quest. A copy of pictures taken, videos recorded, and all material made, should be submitted to the Quest management & shall be the intellectual property of Quest</li>
          <li>Revoking of privileges as enumerated below shall be the sole discretion of the management and the same can be done anytime within the said period with a prior intimation of 7 days by Quest</li>
          <li>No simultaneous personal project can be shot at Quest for the benefit of the trendsetter at the said period</li>
          <li>Travel allowance and accommodation expenses if any, and other personal expenses under the Trendsetter Arrangement apart from clearly stated allowances, to be borne by the Trendsetter. Loss of any personal belongings or harm to any equipment while creating the content or the expense of hiring equipment to be borne by the influencer for the said period</li>
          <li>The Trendsetter arrangement made is not transferable to any other party, agent, representative, fellow, family or colleague</li>
          <li>The privileges too are solely for the Trendsetter and not any other party, fellow, family or colleague</li>
          <li>Giveaways if any, held during the said period needs to be discussed with the Quest management prior to them being handed off to the winner of any contests/competitions etc.; formulated by the trendsetter & the cost of the said prices will be the sole liability of the trendsetter</li>
          <li>Authentic activity reports to be submitted at the end of the said period. All sources of the data obtained by the Trendsetter from should be cited</li>
          <li>All the social media (including but, not limited to YouTube, Facebook, Instagram etc.) creative posts and content that will be created should be vetted by either Brandsum and/or Quest management</li>
          <li>If a Trendsetter is bringing along a team, the details of the said team should be shared with the management at least 72 hours in advance</li>
          <li>The Trendsetter card (details are provided below) is non-transferable. In case of any misplacement of the card or the loss of the card, report such incidents immediately to the management</li>
          <li>All privileges are only valid upon producing the card at the time of billing during the said period</li>
          <li>Brands specified under the Quest Trendsetter Arrangement are subject to the content creation process. Other brands housed under Quest, but not mentioned under the Quest Trendsetter Arrangement are not liable for the same.</li>
        </ol>
          <h5 style="font-weight: bold; color: #d0ad68; font-family: inherit;padding-left: 13px;">Brand-wise</h5>
           <ol style="text-align: left;font-family: inherit;"">
	          <li>The privileges mentioned cannot be clubbed with any other offer existing or ongoing benefits</li>
	          <li>Any product or service dispute arising out of transaction between the Trendsetter and the Brand needs to be settled with the brand in question. Quest and/or employees are not liable to any claim</li>
	          <li>Apart from Quest T&C, brand T&C are also to be followed by the Trendsetter</li>
	          <li>You will be required to show the Trendsetter privilege card to inform the brand that you are a Trendsetter, to avail the privilege</li>
	        </ol>
	        <h5 style="font-weight: bold; color: #d0ad68; font-family: inherit;padding-left: 13px;">Privileges (to be availed by the Trendsetter only for the said period of the arrangement)</h5>
            <ul style="text-align: left;font-family: inherit;"">
			  <li>15% discount on select Restaurants – upto 3 times per month, 4 persons at a time including the Trendsetter</li>
			  <li>Free Valet parking service through a parking ID</li>
			  <li>Free Parking service through a parking ID</li>
			  <li>Inox– Concessions on morning shows</li>
			  <li>10% off on select Retail brands</li>
			  <li>Exclusive Offers on the loft</li>
			</ul>
		  <h5 style="font-weight: bold; color: #d0ad68; font-family: inherit;padding-left: 13px;">Trendsetter Card</h5>
			<ul style="text-align: left;font-family: inherit;"">
			  <li>The aforesaid privileges could be availed by the Trendsetter through a privilege card which would be provided by the Quest management</li>
			  <li>The validity of the card shall remain till the expiry of the said period</li>
			</ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn text-uppercase rounded-0 morebutton" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="plugins/sweetalert-master/sweetalert.min.js"></script>
<script type="text/javascript" src="plugins/fullpage/scrolloverflow.min.js"></script>
<script type="text/javascript" src="plugins/fullpage/jquery.fullpage.min.js"></script>
<script type="text/javascript" src="plugins/fullpage/jquery.fullpage.extensions.min.js"></script>
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

  $(document).on('focusin', 'input', function(event) {
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
	 var leftbox = $('.leftbox').height();
	 var rightbox = $('.rightbox').height();
	 var f_last =  $('.f_last').height();
	 var totalHeight = leftbox + rightbox + f_last;
	 $('body').css('padding-bottom',totalHeight+'px');
  });

	function change_captcha(){
        $.ajax({
          url: '<?=base_url()?>ajax/change_career_code/',
          type: 'GET',
          success:function(data){
            $('#re_cap_career').html(data);
          }
        })
    }

 $('.formbg').submit(function(event) {
 	var validation = true;
 	var work = $("input[name=facinating_piece]").val();
 	var about = $("textarea[name=about]").val();
 	var captcha = $("input[name=captcha]").val();
 	if(work == '')
 	{
 		swal({title:"Please paste link to your most fascinating piece of work!", icon:"warning"});
		validation = false;
		return validation;
 	}else if ($("input[name=facinating_piece]").valid() == false){
 		swal({title:"Please paste valid link to your most fascinating piece of work!", icon:"warning"});
		validation = false;
		return validation;
 	}
 	if(about == '')
 	{
 		swal({title:"Please tell us why you would like to become a Quest Trendsetter!", icon:"warning"});
		validation = false;
		return validation;
 	}
 	if(captcha == '')
 	{
 		swal({title:"Please enter the captcha code!", icon:"warning"});
		validation = false;
		return validation;
 	}
 	if($("input[name='termsCondition']").is(":checked")) {
		validation = true;
	}
	else
	{
		validation = false;
		swal({title:"Please agree to the terms and condition!", icon:"warning"});
		return validation;
	}
 	if(validation){
	    event.preventDefault();
	    $this = this;
	    var postdata =new FormData($('#trendsetter_form')[0]);
	    $('#final_submit').html('<i class="fa fa-refresh fa-spin fa-lg fa-fw"></i>');

	    $.ajax({

	      url: '<?=base_url()?>ajax/career_submit/',

	      type: 'POST',

	      data: postdata,
	      //dataType : 'json',
	      contentType : false,
	      processData : false,
	      success:function(data){
	        //alert(data)
	        console.log(data);
	        data=JSON.parse(data);
	        if(data[0]['type']=='warning'){

	          swal({title:"Sorry!", content:$(data[0]['msg'])[0], icon:"warning"});

	          $('#final_submit').text('Submit');
	        }
	        else{
	        	 fbq('track', 'CompleteRegistration');

	          //swal({title:"Success!", content:$(data[0]['msg'])[0], icon:"success"});
	          //$('.formbg').trigger("reset");
	          $("#logo").css("display","none");
	          $("#slide7").css("display", "none");
			  $("#slide8").css("display", "");
			  window.history.pushState('page2', 'Thank you', '/trendsetter/thankyou');
	        }

	      }

	    })
	    return false;
	}

});

 $('[name=current_endorsing]').click(function(event) {
 	var value = $(this).val();
 	if(value == 1)
 	{
 		$('#brandLevel').show();
 		$('#brandInput').show();
 	}
 	else
 	{
 		$('#brandLevel').hide();
 		$('#brandInput').hide();
 	}

 });

//  $('#all').click(function(){

//       $('.foo-check').attr('checked', false);
//       $(this).attr('checked', true);

// });

// $('.foo-check').click(function(){
//       $('#all').attr('checked', false);

// });

$('#all').change(function () {
    if ($(this).prop('checked')) {
        $('.foo-check').prop('checked', true);
    } else {
        $('.foo-check').prop('checked', false);
    }
});
$('#all').trigger('change');

$('.foo-check').click(function(){
      $('#all').attr('checked', false);

});


function add_social_links(btn) {
	var index = $('#add_social_links>.social').length;

	var input = $('<div class="input-group mb-lg-2 mb-md-2 mb-1 social"><input type="url" class="form-control rounded-0" name="social_links[]" id="" placeholder=""><span class="input-group-btn"><button type="button" class="btn btn-danger waves-effect" onclick="removeDiv(this)"><i class="fa fa-times" aria-hidden="true"></i></button></span></div>');
	$('#add_social_links').append(input);
	if(index >= 2)
	{
		$('#add_social_btn').hide();
	}

}

function removeDiv(btn)
{
	var index = $('#add_social_links>.social').length;
	$(btn).closest('div').remove();
	if(index <= 3)
	{
		$('#add_social_btn').show();
	}
}

function Check()
{
	$("#slide0").css("display", "none");
	$("#logo").css("display","block");
    $("#slide1").css("display", "table");
    $.fn.fullpage.moveSlideLeft();
}
function slideOneCheck()
{
	var validation = true;
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var name = $("input[name=name]").val();
	if(name == ''){
		swal({title:"Please enter your name!", icon:"warning"});
		validation = false;
		return validation;
	}
	var email = $("input[name=email]").val();
	if(email == ''){
		swal({title:"Please enter your email!", icon:"warning"});
		validation = false;
		return validation;
	}
	if(!regex.test(email)) {
		swal({title:"Please enter valid email id!", icon:"warning"});
		validation = false;
		return validation;
	}
	var phone = $("input[name=phone]").val();
	if(phone == ''){
		swal({title:"Please enter your mobile number!", icon:"warning"});
		validation = false;
		return validation;
	}
	if($.isNumeric(phone)==false)
	{
		swal({title:"Please enter valid mobile number!", icon:"warning"});
		validation = false;
		return validation;
	}
	if(phone.toString().length != 10)
	{
		swal({title:"Please enter valid mobile number!", icon:"warning"});
		validation = false;
		return validation;
	}
	if ($("input[name='profession']").is(":checked")) {
		validation = true;
	}
	else
	{
		validation = false;
		swal({title:"Please select your profession!", icon:"warning"});
		return validation;
	}
	if(validation)
	{
		$("#slide0").css("display", "none");
		$("#slide1").css("display", "none");
		$("#slide2").css("display", "");
		$.fn.fullpage.moveSlideLeft();

	}
}
function slideTwoCheck(){

	var validation = true;
	var social_media = $('input[name="category[]"]:checked').length;
	if (social_media > 0) {
		validation = true;
	}
	else
	{
		validation = false;
		swal({title:"Please choose a category or categories you specialize in!", icon:"warning"});
	}

	if(validation)
	{
		$("#slide2").css("display", "none");
		$("#slide3").css("display", "");
		$.fn.fullpage.moveSlideLeft();
	}
}

function slideThreeCheck(){
	var validation = true;
	if ($("input[name='experience']").is(":checked")) {
		validation = true;
	}
	else
	{
		validation = false;
		swal({title:"Please select your span of experience!", icon:"warning"});
	}
	if(validation)
	{
		$("#slide3").css("display", "none");
		$("#slide4").css("display", "");
		$.fn.fullpage.moveSlideLeft();
	}
}
function slideFourCheck(){

	var validation = true;
	var social_media = $('input[name="preffered_social_media[]"]:checked').length;
	if (social_media > 0) {
		validation = true;
	}
	else
	{
		validation = false;
		swal({title:"Please select your preferred social media pages!", icon:"warning"});
	}
	if(validation)
	{
		$("#slide4").css("display", "none");
		$("#slide5").css("display", "");
		$.fn.fullpage.moveSlideLeft();
	}
}
function slideFiveCheck(){

	var validation = true;
	var brandsName = $("input[name='current_endorsing']:checked").val();
	if ($("input[name='curate_content']").is(":checked")) {
		validation = true;
	}
	else
	{
		validation = false;
		swal({title:" Please mention how often you would like to curate content for us!", icon:"warning"});
		return validation;
	}
	if ($("input[name='current_endorsing']").is(":checked")) {
		validation = true;
	}
	else
	{
		validation = false;
		swal({title:"Are there any other brands that you are currently endorsing? ", icon:"warning"});
		return validation;
	}
	if(brandsName == '1')
	{
		var brands = $("input[name='endorse_name']").val();
		if (brands=='')
		{
			validation = false;
		    swal({title:" Please mention the brand or brands you endorse!", icon:"warning"});
		    return validation;
		}
	}
	if(validation)
	{
		$("#slide5").css("display", "none");
		$("#slide6").css("display", "");
	}
}
function slideSixCheck(){

	var validation = true;
	$("input[name='social_links[]']").each(function(i,v){
		if($(v).val() == ''){
			swal({title:"Please enter your social links!", icon:"warning"});
			validation = false;
		}else if($(v).valid() == ''){
			swal({title:"Please enter valid social links!", icon:"warning"});
			validation = false;
		}
	}).promise().done(function(){
		if(validation)
		{
			$("#slide6").css("display", "none");
			$("#slide7").css("display", "");
		}
	})
}

function previousSlideOne()
{
	$("#slide2").css("display", "none");
	$("#slide1").css("display", "");
}
function previousSlideTwo()
{
	$("#slide3").css("display", "none");
	$("#slide2").css("display", "");
}

function previousSlideThree()
{
	$("#slide4").css("display", "none");
	$("#slide3").css("display", "");
}
function previousSlideFour()
{
	$("#slide5").css("display", "none");
	$("#slide4").css("display", "");
}
function previousSlideFive()
{
	$("#slide6").css("display", "none");
	$("#slide5").css("display", "");
}
function previousSlideSix()
{
	$("#slide7").css("display", "none");
	$("#slide6").css("display", "");
}



$(function($) {
    $.ajaxSetup({
        data: {
            <?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'
        }
    });
});
</script>
<?php
if($_GET['id']=="signup")
{
?>
<script type="text/javascript">
	$(document).ready(function() {
		Check();
	});
</script>
<?php
}
?>

</html>