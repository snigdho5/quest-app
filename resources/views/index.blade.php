@extends('layout.master')
@section('content')

    <div id="pageBody">
        <div class="container-fluid">
            <div id="sliderPanel" class="row mt-lg-5 mb-lg-5 mb-0 mt-4">
                @if ($deals->count() > 0)
                    <!-- <div class="col-lg-4 col-md-6 col-sm-6 order-2 order-sm-1">
                    <div class="positionbox" id="topmobilebanner1">
                        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                            <div class="carousel-inner">
                            @foreach ($deals as $key => $value)
    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <a href="javascript:void(0)" style="background-image: url({{ asset('storage/store_deal/thumb/' . $value->image) }}); background-color: #ccc;">

                                    </a>
                                </div>
    @endforeach
                            </div>
                        </div>
                        <div class="dealHover">
                            <a href="deals"><p>There {{ $totalDeals == 1 ? 'is' : 'are' }} {{ $totalDeals }} deal{{ $totalDeals > 1 ? 's' : '' }} awaiting you</p></a>

                            <div class="morelink mt-3 d-inline-block" id="morelink">
                                <a href="deals" class="shopinglink"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>
                                <a href="deals" class="pagelink" id="pagelink04">Explore</a>
                            </div>
                        </div>
                    </div>
                </div> -->
                @endif
                <div class="{{ $deals->count() > 0 ? 'col-lg-12 col-md-6 col-sm-6' : 'col-sm-12' }} order-1 order-sm-2">
                    <div class="positionbox" id="topmobilebanner">
                        <div id="carouselExampleFade2" class="carousel slide carousel-fade" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach ($banner as $key => $value)
                                    <li data-target="#carouselExampleFade2" data-slide-to="{{ $key }}"
                                        class="{{ $key == 0 ? 'active' : '' }}"></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach ($banner as $key => $value)
                                    <a target="{{ $value->link_open == 1 ? '_blank' : 'self' }}" href="{{ $value->link }}"
                                        class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/banner/actual/' . $value->image) }}"
                                            class="img-fluid d-none d-lg-block w-100" alt="">
                                        <img src="{{ asset('storage/banner/thumb/' . $value->sq_image) }}"
                                            class="img-fluid d-block d-lg-none w-100" alt="">
                                        {{-- <div class="contentbox">
                                    <h2>{{ $value->title }}</h2>
                                    <div class="morelink mt-3" id="morelink">
                                        <a href="{{ $value->link }}" class="shopinglink"><i class="fa fa-{{ $value->btn_icon }}" aria-hidden="true"></i></a>
                                        <a href="{{ $value->link }}" class="pagelink" id="pagelink04">{{ $value->btn_text }}</a>
                                    </div>
                                </div> --}}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="javascript:void(0)" id="download_now"></a>
            <!-- app offer-->



            <div id="app-use" class="container-fluid app-user">
                <div class="container">
                    <h2>Current offers</h2>
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <div class="android">
                                <a href="https://play.google.com/store/apps/details?id=in.quest.main" target="_blank"><img
                                        src="images/playstrore.png"></a>
                            </div>
                        </div>

                        <div class="col-md-6 col-6">
                            <div class="ios">
                                <a href="https://apps.apple.com/us/app/id1476034996" target="_blank"><img
                                        src="images/ios.png"></a>
                            </div>
                        </div>

                    </div>

                    <div class="owl-carousel owl-theme">

                        @foreach ($deals as $key => $value)
                            <div class="item">
                                <div class="app-offer">

                                    <a href="javascript:void(0)"> <img
                                            src=" {{ asset('storage/store_deal/thumb/' . $value->image) }}">
                                    </a>
                                    <h4>{{ $value->store['name'] }}</h4>

                                    <div class="offer-valid">
                                        <h6>Offer Valid Till</h6>
                                        <p>
                                            {{ $value->start_date->format('dS M, y') }} -
                                            {{ $value->end_date->format('dS M, y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach




                    </div>


                </div>
            </div>
            <!--end offer-->

            <!-- app offer-->



            <!-- <div id="app-use" class="container-fluid app-user">
            <div class="container">
            <h2>Current offers</h2>
          

            <div class="owl-carousel owl-theme">
                
      
                <div class="item">
                    <div class="app-offer">
                        
                       <a href="https://questmall.in/stores/skechers"> <img src=" {{ asset('storage/store_deal/thumb/Mainline-Stores-Offer.jpg') }}">
                       </a>
                        <h4>Skechers</h4>

                      <div class="offer-valid" >
                    <h6>Offer Valid Till</h6>
                    <p>
                    18 Oct,21 - 30 Oct,21
                    </p>
                    </div>
                    </div>
                </div>

                <div class="item">
                    <div class="app-offer">
                        
                       <a href="javascript:void(0)"> <img src=" {{ asset('storage/store_deal/thumb/1200-x-1200-2.jpg') }}">
                       </a>
                        <h4>Lifestyle</h4>

                      <div class="offer-valid" >
                    <h6>Offer Valid Till</h6>
                    <p>
                    18 Oct,21 - 4 Nov,21
                    </p>
                    </div>
                    </div>
                </div>

                <div class="item">
                    <div class="app-offer">
                        
                       <a href="javascript:void(0)"> <img src=" {{ asset('storage/store_deal/thumb/MID-SEASON-SALE-Communication.jpg') }}">
                       </a>
                        <h4>Puma</h4>

                      <div class="offer-valid" >
                    <h6>Offer Valid Till</h6>
                    <p>
                    18 Oct,21 - 30 Oct,21
                    </p>
                    </div>
                    </div>
                </div>

                <div class="item">
                    <div class="app-offer">
                        
                       <a href="javascript:void(0)"> <img src=" {{ asset('storage/store_deal/thumb/Diwali-Exclusive-Offer.jpg') }}">
                       </a>
                        <h4>Forest Essentials</h4>

                      <div class="offer-valid" >
                    <h6>Offer Valid Till</h6>
                    <p>
                    21 Oct,21 - 04 Nov,21
                    </p>
                    </div>
                    </div>
                </div>
                <div class="item">
                    <div class="app-offer">
                        
                       <a href="javascript:void(0)"> <img src=" {{ asset('storage/store_deal/thumb/diwalisale.jpg') }}">
                       </a>
                        <h4>Tribe Amrapali</h4>

                      <div class="offer-valid" >
                    <h6>Offer Valid Till</h6>
                    <p>
                    24 Oct,21 - 04 Nov,21
                    </p>
                    </div>
                    </div>
                </div>
                <div class="item">
                    <div class="app-offer">
                        
                       <a href="javascript:void(0)"> <img src=" {{ asset('storage/store_deal/thumb/248288948.jpg') }}">
                       </a>
                        <h4>Tribe Amrapali</h4>

                      <div class="offer-valid" >
                    <h6>Offer Valid Till</h6>
                    <p>
                    27 Oct,21 - 04 Nov,21
                    </p>
                    </div>
                    </div>
                </div>
                
                
             
                                
                              
               
                
            </div>

            
        </div>
        </div> -->
            <!--end offer-->
            <!-- store-->

            <div class="col-md-12" id="dealsbox">
                <div class="row">

                    @foreach ($storeData as $key => $value)
                        <div class="col-lg-2 col-md-6 col-6 left-dealboximg"> <img
                                src="{{ asset('storage/store_banner/thumb/' .$value->banner()->where('featured', '1')->first()['image']) }}"
                                alt=""></div>
                        <div class="col-lg-2 col-md-6 col-6 right-dealboximg">
                            <a href="stores/{{ str_slug($value->name) }}" title="{{ $value->name }}">
                                <div class="dealsbox">

                                    <span class="dealbg"
                                        style="background-image: url({{ asset('storage/store_banner/thumb/' .$value->banner()->where('featured', '1')->first()['image']) }})">

                                        <div class="whitecolor">
                                            <img src="{{ asset('storage/store/actual/' . $value->logo) }}"
                                                class="img-fluid logobg" alt="{{ $value->name }}">
                                        </div>
                                        @if ($value->deals()->where([['active', '1'], ['image', '!=', ''], ['beacon_type', '0'], ['post_time', '<=', date('Y-m-d H:i:s')]])->whereDate('end_date', '>', date('Y-m-d'))->count() > 0)
                                            <div class="imagetext">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                    y="0px" width="45px" height="45px" viewBox="0 0 45 45"
                                                    enable-background="new 0 0 45 45" xml:space="preserve">
                                                    <polygon fill="#FBAE2F"
                                                        points="0,0.003 0,44.997 21.997,35.834 45,45 45,0 " />
                                                </svg>
                                                <span>DEALS</span>
                                            </div>
                                        @endif
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
            <!-- end store-->
            <div class="container-fluid middile-banner">

            </div>


            <div class=container>
                <div id="parkingNContent" class="row mt-lg-5 mb-2">
                    {{-- <div class="col-lg-6 col-md-6 d-none d-sm-none d-md-none d-lg-block">
                <div class="parkingbox" style="background-color: #161616; background-image: url('images/prebookhand.png'); background-position: right bottom; background-size: 220px; background-repeat: no-repeat">
                    <div class="parkingcontent">
                        <!-- <h1 class="mb-0 mt-0">Book your</h1> -->
                        <h2 class="mb-0 mt-0">Prebook Your Visit</h2>
                        <p class="textparagraph text-white" style="font-size: 16px; width: 60%">You can now pre-book your visit to the mall using the Quest app.<br><span style="color: #d0ad68">Avoid long queues</span>, enter via a separate line and enjoy a <span style="color: #d0ad68">worry-free</span> experience at the mall.</p>
                        <span class="colortext">Download Quest App now!!</span>
                        <div class="googleicon">
                            <a href="https://apps.apple.com/us/app/id1476034996" target="_blank"><img id="parking_ios_app_link" src="images/appstoreicon.png" class="img-fluid" alt="Responsive image"></a>
                            <a href="https://play.google.com/store/apps/details?id=in.quest.main" target="_blank"><img id="parking_android_app_link" src="images/googlepayicon.png" class="img-fluid" alt="Responsive image"></a>
                        </div>
                    </div>
                </div>
            </div> --}}
                    <div class="col-lg-6 col-md-6 d-none d-sm-none d-md-none d-lg-block">
                        <div class="parkingbox"
                            style="background-color: #161616; background-image: url('images/dnwback.png'); background-position: right bottom; background-size: 220px; background-repeat: no-repeat">
                            <div class="parkingcontent">
                                <!-- <h1 class="mb-0 mt-0">Book your</h1> -->
                                <h2 class="mb-0 mt-0">Dine & Win</h2>
                                <p class="textparagraph text-white" style="font-size: 14px; margin-top: 13px;">The
                                    yummiest offer of the season is here. <br>Get rewarded for every time you eat at Quest
                                    and pay lesser on your next visit. </p>
                                <img src="images/dnwlogos.png" alt="" style="width:280px"><br>
                                <div class="colortext" style="width: 50%; font-size: 14px">Download the Quest App now to
                                    start collecting rewards!</div>
                                <div class="googleicon">
                                    <a href="https://apps.apple.com/us/app/id1476034996" target="_blank"><img
                                            id="parking_ios_app_link" src="images/appstoreicon.png" class="img-fluid"
                                            alt="Responsive image"></a>
                                    <a href="https://play.google.com/store/apps/details?id=in.quest.main"
                                        target="_blank"><img id="parking_android_app_link" src="images/googlepayicon.png"
                                            class="img-fluid" alt="Responsive image"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 d-none d-sm-none d-md-none d-lg-block">

                        <div class="parkingbox">
                            <div class="parkingcontent">
                                <!-- <h1 class="mb-0 mt-0">Book your</h1> -->
                                <h2 class="mb-0 mt-0">Park Your Car</h2>
                                <p class="mb-0 mt-0 mt-1" style="color: #dec279;">Pay online!</p>
                                <p class="textparagraph text-white">Pay for your parking space using Quest App & avail 100%
                                    cashback! *T&C apply</p>
                                <span class="colortext">Download Quest App now!!</span>
                                <div class="googleicon">
                                    <a href="https://apps.apple.com/us/app/id1476034996" target="_blank"><img
                                            id="parking_ios_app_link" src="images/appstoreicon.png" class="img-fluid"
                                            alt="Responsive image"></a>
                                    <a href="https://play.google.com/store/apps/details?id=in.quest.main"
                                        target="_blank"><img id="parking_android_app_link" src="images/googlepayicon.png"
                                            class="img-fluid" alt="Responsive image"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-6 walkmobile d-block d-sm-block d-md-block d-lg-none">
                <div class="card rounded-0 h-100">
                  <img src="images/prebookmobile.jpeg" class="img-fluid" alt="Responsive image">
                  <div class="card-body walkmobile_cont1">
                    <!-- <div class="w-100" style="display: inline-block;">
                        <h1 class="card-title mb-0">W</h1>
                        <span class="walk mb-0">ALK'n'<br>IN</span>
                    </div> -->
                    <p class="card-text mb-0">You can now pre-book your visit to the mall using the Quest app.<br><br><span style="color: #d0ad68">Avoid long queues</span>, enter via a separate line and enjoy a <span style="color: #d0ad68">worry-free</span> experience at the mall.</p>
                    <span class="colortext">Download Quest App now!!</span>
                    <div class="googleicon card-footer">
                        <a href="https://apps.apple.com/us/app/id1476034996" target="_blank"><img src="images/appstoreicon.png" class="img-fluid" alt="Responsive image"></a>
                        <a href="https://play.google.com/store/apps/details?id=in.quest.main" target="_blank"><img src="images/googlepayicon.png" class="img-fluid" alt="Responsive image"></a>
                    </div>
                  </div>
                </div>
            </div> --}}

                    <div class="col-md-6 walkmobile d-block d-sm-block d-md-block d-lg-none">
                        <div class="card rounded-0 h-100">
                            <img src="images/dnwmobile.png" class="img-fluid" alt="Responsive image">
                            <div class="card-body walkmobile_cont1">
                                <p class="card-text mb-0">The yummiest offer of the season is here.<br>Get rewarded for
                                    every time you eat at Quest and pay lesser on your next visit. </p>
                                <span class="colortext">Download the Quest App now to start collecting rewards!</span>
                                <div class="googleicon card-footer">
                                    <a href="https://apps.apple.com/us/app/id1476034996" target="_blank"><img
                                            src="images/appstoreicon.png" class="img-fluid" alt="Responsive image"></a>
                                    <a href="https://play.google.com/store/apps/details?id=in.quest.main"
                                        target="_blank"><img src="images/googlepayicon.png" class="img-fluid"
                                            alt="Responsive image"></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 walkmobile d-block d-sm-block d-md-block d-lg-none" id="walkmobile02">
                        <div class="card rounded-0 h-100">
                            <img src="images/walkimgmob02.jpg" class="img-fluid" alt="Responsive image">
                            <div class="card-body">
                                <!-- <div class="card-title w-100 mb-0">
                            <h1 class="w-100">Book your <br><b>Parking</b></h1><br>
                            <span>before you reach!</span>
                        </div> -->
                                <p class="card-text mb-0">Now assured parking in your hand. Book your parking space using
                                    Quest App & pay on the go. Avail 100% cashback on parking. *T&C apply</p>
                                <span class="colortext">Download Quest App now!!</span>
                                <div class="googleicon card-footer">
                                    <a href="https://apps.apple.com/us/app/id1476034996" target="_blank"><img
                                            src="images/appstoreicon.png" class="img-fluid" alt="Responsive image"></a>
                                    <a href="https://play.google.com/store/apps/details?id=in.quest.main"
                                        target="_blank"><img src="images/googlepayicon.png" class="img-fluid"
                                            alt="Responsive image"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- booking section-->
            <div class="container">
                <div id="bookingSection" class="row mt-5 mb-2">
                    <div class="col-12">
                        <div class="questmalbg">
                            <span class="topborder"></span>
                            <span class="rightborder"></span>
                            <span class="leftborder"></span>
                            <span class="bottomborder"></span>
                            <div id="carouselExampleFade3" class="carousel slide carousel-fade" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach ($dines as $key => $value)
                                        <li data-target="#carouselExampleFade3" data-slide-to="{{ $key }}"
                                            class="{{ $key == 0 ? 'active' : '' }}"></li>
                                    @endforeach
                                </ol>
                                <div class="carousel-inner">
                                    @foreach ($dines as $key => $value)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}"
                                            style="background-image: url({{ asset('storage/store_banner/actual/' .$value->banner()->where('featured', '1')->first()['image']) }})">
                                            <div class="tablebook">
                                                {{-- <h1>BOOK</h1>
                                    <h2>A TABLE</h2><br> --}}
                                                <div class="morelink">
                                                    <a href="dines/{{ str_slug($value->name) }}" class="shopinglink"><i
                                                            class="fa fa-cutlery" aria-hidden="true"></i></a>
                                                    <a href="dines/{{ str_slug($value->name) }}" class="pagelink"
                                                        id="pagelink04">BOOK A TABLE NOW</a>
                                                </div>
                                            </div>
                                            <div class="bgbox">
                                                <img src="images/home-booking-triangle.svg" alt=""
                                                    class="d-none d-sm-block d-md-block d-lg-block">
                                                <svg version="1.1" class="d-block d-sm-none d-md-none d-lg-none"
                                                    id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                    y="0px" width="230px" height="230px" viewBox="0 0 230 230"
                                                    enable-background="new 0 0 230 230" xml:space="preserve">
                                                    <polyline fill="#00A68E" points="230,0 100.095,230 0,230 0,0 " />
                                                </svg>
                                            </div>
                                            <div class="ourmisson">
                                                <h2>{{ $value->name }}</h2>
                                                @php
                                                    $cuisine = explode(',', $value->cuisine);
                                                    foreach ($cuisine as $key => $value) {
                                                        $cuisine[$key] = get_anydata('cuisine', $value, 'title');
                                                    }
                                                @endphp
                                                <p>{{ implode(', ', $cuisine) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- booking section-->


            <!-- top resturant-->
            <div class="container-fluid top-resturent">
                <div class="container">
                    <h2>top restaurants</h2>

                    <div class="owl-carousel owl-theme">
                        @foreach ($dineData as $key => $value)
                            <div class="item">
                                <div class="resturent" id="dealsbox">


                                    <a href="dines/{{ str_slug($value->name) }}" title="{{ $value->name }}">
                                        <div class="dealsbox">
                                            <span class="dealbg"
                                                style="background-image: url({{ asset('storage/store_banner/thumb/' .$value->banner()->where('featured', '1')->first()['image']) }})">
                                                <div class="whitecolor">
                                                    <img src="{{ asset('storage/store/actual/' . $value->logo) }}"
                                                        class="img-fluid logobg" alt="{{ $value->name }}">
                                                </div>
                                                @if ($value->deals()->where([['active', '1'], ['image', '!=', ''], ['beacon_type', '0'], ['post_time', '<=', date('Y-m-d H:i:s')]])->whereDate('end_date', '>', date('Y-m-d'))->count() > 0)
                                                    <div class="imagetext">
                                                        <svg version="1.1" id="Layer_1"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                            y="0px" width="45px" height="45px"
                                                            viewBox="0 0 45 45" enable-background="new 0 0 45 45"
                                                            xml:space="preserve">
                                                            <polygon fill="#FBAE2F"
                                                                points="0,0.003 0,44.997 21.997,35.834 45,45 45,0 " />
                                                        </svg>
                                                        <span>DEALS</span>
                                                    </div>
                                                @endif
                                            </span>
                                        </div>
                                    </a>


                                </div>
                            </div>
                        @endforeach



                    </div>

                </div>
            </div>
            <!-- end top resturant-->

            <!-- spencer -->
            <div class="container spencer">
                <div class="row">
                    <div class="col-md-6">
                        <div class="spencer-text">
                            <h6>MARKET PLACE</h6>
                            <h5>UPPER BASEMENT</h5>
                            <h3>A Family Convenience Store</h3>
                            <p>Spencer’s Retail Limited, a part of the RP-Sanjiv Goenka Group, is a multi-format retailer
                                providing a wide range of quality products across categories such as food, personal care,
                                fashion, home essentials, electrical and electronics to its key consumers.</p>
                            <img src="images/SPENCERS.png">
                            <h4><a href="https://questmall.in/stores/spencers">Explore </a></h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="spencer-image">

                        </div>
                    </div>
                </div>
            </div>
            <!-- end spencer-->

            <!-- whats new-->

            <!-- <div class="container-fluid whats-new">
            <div class="container">
                <h2>What's New</h2>

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" src="images/whatsnew2.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="images/videoShoppingBanner.jpg" alt="Second slide">
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>

            </div>
        </div> -->
            <!-- end whats new-->

            <!--- event section-->


            <div class="container latest-event">
                <h2>Past Events</h2>
                <div class="row d-flex justify-content-end">
                    <div class="col-lg-6 col-md-8 mb-4">

                    </div>
                </div>
                <div class="row deals_cont" id="deals_cont">
                    @if ($eventsData->count() == 0)
                        <div class="col-sm-12">
                            <h4 class="mt-5 mb-5 text-center text-muted">Sorry! We couldn't find any
                                event.<br><small>Please try again with different preferences.</small></h4>
                            <div class="morelink mt-3 d-inline-block d-flex justify-content-center" id="morelink">
                                <a href="{{ Request::url() }}" class="shopinglink"><i class="fa fa-chevron-left"
                                        aria-hidden="true"></i></a>
                                <a href="{{ Request::url() }}" class="pagelink" id="pagelink04">Go Back</a>
                            </div>
                        </div>
                    @endif
                    @foreach ($eventsData as $key => $value)
                        <div class="col-lg-4 col-md-6 col-12 mb-4">
                            <span class="border-bottom"></span>
                            <a href="events/{{ $value->slug }}">
                                <div class="card border-0">
                                    <img src="{{ asset('storage/event/thumb/' . $value->sq_image) }}"
                                        class="card-img-top rounded-0" alt="..."
                                        style="border:thin solid rgba(0,0,0,0.1)">
                                    <div class="card-body pl-0 p-0 pt-lg-1 pt-2">
                                        <span class="card-title"><b>{{ $value->title }}</b></span><br>
                                    </div>
                                    <div class="d_cont pt-1">
                                        <h6 class="mb-0 float-left" style="color: #404041;">
                                            {{ $value->start_date->format('dS M, Y') }}</h6>
                                        <h6 class="mb-0 float-right" style="color: #404041;">
                                            {{ $value->end_date->format('dS M, Y') }}</h6>
                                    </div>
                                    <small class="text-muted mt-2">{!! str_limit(strip_tags($value->content), 100) !!}</small>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>


            </div>


            <!--end event section-->
            <div class="container">
                <div id="movieNblogSection" class="row mt-4 mb-4">
                    <div class="col-lg-4 col-md-6">
                        {{-- <div id="carouselExampleFade4" class="carousel slide carousel-fade" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($moviePoster as $key => $value)
                        <li data-target="#carouselExampleFade4" data-slide-to="{{$key}}" class="{{$key==0?'active':''}}"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                    	@foreach ($moviePoster as $key => $value)
                        <div class="carousel-item {{$key==0?'active':''}}">
                            <img src="{{ asset('storage/movie_poster/actual/'.$value->image) }}" class="img-fluid" alt="{{ $value->title }}">
                            <div class="bookshow d-flex justify-content-center">
                                <div class="morelink">
                                    <a href="{{ $value->link }}" target="_blank" class="shopinglink"><i class="fa fa-video-camera" aria-hidden="true"></i></a>
                                    <a href="{{ $value->link }}" target="_blank" class="pagelink" id="pagelink03">BOOK YOUR SHOW</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div> --}}

                        {{-- <div class="walkmobile d-block d-sm-block d-md-block d-lg-none">
	                <div class="card rounded-0 h-100">
	                  <img src="images/walkimgmob01.jpg" class="img-fluid" alt="Responsive image">
	                  <div class="card-body walkmobile_cont1">
	                    <!-- <div class="w-100" style="display: inline-block;">
	                        <h1 class="card-title mb-0">W</h1>
	                        <span class="walk mb-0">ALK'n'<br>IN</span>
	                    </div> -->
	                    <p class="card-text mb-0">Download the Quest app and stand a chance to <span style="color: #d0ad68">win amazing goodies</span> from Quest. Just by walking inside the mall.</p>
	                    <span class="colortext">Download Quest App now!!</span>
	                    <div class="googleicon card-footer">
	                        <a href="https://apps.apple.com/us/app/id1476034996" target="_blank"><img src="images/appstoreicon.png" class="img-fluid" alt="Responsive image"></a>
	                        <a href="https://play.google.com/store/apps/details?id=in.quest.main" target="_blank"><img src="images/googlepayicon.png" class="img-fluid" alt="Responsive image"></a>
	                    </div>
	                  </div>
	                </div>
				</div>

                <div class="walkbox d-none d-sm-none d-md-none d-lg-block" style="height: auto">
                    <div class="walkboxcontent" style="position: static; transform: none;">
                    	
                        <div class="row d-flex align-items-center">
                            <div class="col-md-6 p-0">
                                <div class="mb-4">
                                    <h1>W</h1><span class="walk">ALK <span style="color: #fff ;font-size: 16px;">'N'</span> <br>IN</span>
                                </div>
                           </div>
                            <div class="col-md-6 p-0">
                            	<img src="images/walkingicons.png" class="img-fluid" alt="">
                            </div>
                           <div class="col-md-12 p-0 pt-2">
                                <p>Download the Quest app and stand a chance to <span style="color: #d0ad68">win amazing goodies</span> from Quest.<br><br>Just by walking inside the mall.</p>
                                <span class="colortext">Download Quest App now!!</span>
                                
                            </div>

							<div class="col-12 p-0">
								<div class="googleicon">
                                    <a  href="https://apps.apple.com/us/app/id1476034996" target="_blank"><img id="walknwin_ios_app_link"  src="images/appstoreicon.png" class="img-fluid" alt="Responsive image"></a>
                                    <a href="https://play.google.com/store/apps/details?id=in.quest.main" target="_blank"><img id="walknwin_android_app_link" src="images/googlepayicon.png" class="img-fluid" alt="Responsive image"></a>
                                </div>
							</div>
                        </div>
                    </div>
                </div> --}}

                        {{-- <iframe src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fquestmallofficial%2Fvideos%2F282860979691464%2F&show_text=0&width=560" width="100%" height="250" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe> --}}

                        <div class="blog">
                            <h2 class="mb-4">Q-LIVE</h2>
                        </div>
                        <div style="cursor: pointer;" onclick="showLive()">
                            {{-- <img src="images/fbliveimg.jpeg" alt="" class="img-fluid d-none d-sm-none d-md-none d-lg-block"> --}}
                            <img src="images/fbliveimg_m.jpeg" alt="" class="img-fluid border">
                        </div>

                        <div class="modal fade" id="liveModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content" style="background-color: transparent; border:none">
                                    <div class="modal-header">
                                        <h5 class="modal-title"></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body p-0">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function showLive() {
                                $('#liveModal .modal-body').html($(
                                    '<iframe src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fquestmallofficial%2Fvideos%2F282860979691464%2F&show_text=0&width=560" width="100%" height="315" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>'
                                    ));
                                $('#liveModal').modal('show');
                            }
                            $('#liveModal').on('hide.bs.modal', function(event) {
                                $('#liveModal .modal-body').html("");
                            });
                        </script>
                    </div>




                    <div class="col-lg-8 col-md-6">
                        <div class="row">
                            <!-- <div class="col-lg-6 col-md-12 col-md order-1">
                            <div class="blog">
                                <h2 class="mb-4">Q-REVIEW</h2>
                                <img src="{{ asset('storage/qreview/actual/' . $qreview->image) }}" class="mr-3 img-fluid" alt="{{ $qreview->title }}">
                                <div class="media venuebox mt-3">
                                  <div class="media-body">
                                    <span><small><i class="fa fa-calendar" aria-hidden="true"></i>{{ date('dS M, Y', strtotime($qreview->post_time)) }}</small></span>
                                    <p><a href="qreview/{{ $qreview->slug }}">{{ $qreview->title }}</a></p>
                                  </div>
                                </div>
                            </div>
                        </div> -->
                            <div class="col-lg-6 col-md-12 col-md order-1">
                                <div class="blog">
                                    <h2 class="mb-4">Q-BLOG</h2>
                                    @foreach ($blogs as $key => $value)
                                        <div class="media venuebox">
                                            <img src="{{ asset('storage/blog/thumb/' . $value->sq_image) }}" class="mr-3"
                                                alt="{{ $value->title }}" width="70px">
                                            <div class="media-body">
                                                <span><small><i class="fa fa-calendar"
                                                            aria-hidden="true"></i>{{ date('dS M, Y', strtotime($value->post_time)) }}</small></span>
                                                <p><a href="blogs/{{ $value->slug }}">{{ $value->title }}</a></p>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="morelink" id="morelink">
                                        <a href="blogs" class="shopinglink"><i class="fa fa-book"
                                                aria-hidden="true"></i></a>
                                        <a href="blogs" class="pagelink" id="pagelink04">READ MORE</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="zegnabgbox d-none d-sm-none d-md-none d-lg-block">
                            <div id="carouselExampleFade5" class="carousel slide carousel-fade d-none"
                                data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach ($events as $key => $value)
                                        {{-- <li data-target="#carouselExampleFade5" data-slide-to="{{$key}}" class="{{$key==0?'active':''}}"></li> --}}
                                    @endforeach
                                </ol>
                                <div class="carousel-inner">
                                    @foreach ($events as $key => $value)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            {{-- <span class="topborder"></span>
                                <span class="rightborder"></span>
                                <span class="leftborder"></span>
                                <span class="bottomborder"></span> --}}
                                            <a href="the-loft/events/{{ $value->slug }}">
                                                <img src="{{ asset('storage/event/actual/' . $value->image) }}"
                                                    class="img-fluid" alt="{{ $value->title }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-md-4">
                <div class=" col-lg-8 col-md-12 d-block d-sm-block d-md-block d-lg-none">
                    <div class="zegnabgbox d-none">
                        <div id="carouselExampleFade6" class="carousel slide carousel-fade" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach ($events as $key => $value)
                                    {{-- <li data-target="#carouselExampleFade6" data-slide-to="{{$key}}" class="{{$key==0?'active':''}}"></li> --}}
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach ($events as $key => $value)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <a href="the-loft/events/{{ $value->slug }}">
                                            <img src="{{ asset('storage/event/thumb/' . $value->sq_image) }}"
                                                class="img-fluid border" alt="{{ $value->title }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>


@endsection
