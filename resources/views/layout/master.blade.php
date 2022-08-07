<!DOCTYPE html>
<html>
  <head>
    @php
    $title = $linkData?$linkData->meta_title.' | '.config('app.name'):(isset($metaData)?($metaData->meta_title?$metaData->meta_title.' | '.config('app.name'):($metaData->title?$metaData->title.' | '.config('app.name'):config('app.name'))):config('app.name'));
    $desc = $linkData?$linkData->meta_desc:(isset($metaData)?$metaData->meta_desc:'');
    $keyword = $linkData?$linkData->meta_keyword:(isset($metaData)?$metaData->meta_keyword:'');

    $meta_img = (isset($metaData)?(isset($metaData->meta_image)?asset('storage/link_data/'.$metaData->meta_image):''):'');
    $meta_img = $meta_img==''?asset('storage/link_data/actual/'.(isset($linkData)?(isset($linkData->meta_image)?$linkData->meta_image:'meta-image.jpg'):'meta-image.jpg')):$meta_img;
    @endphp

    <base href="{{config('app.base_url')}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $desc }}"/>
    <meta name="keywords" content="{{ $keyword }}"/>

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{Request::fullUrl()}}">
    <meta property='og:title' content='{{ $title }}' />
    <meta property='og:description' content='{{ $desc }}' />
    <meta property='og:image' content='{{ $meta_img }}' />

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{Request::fullUrl()}}">
    <meta property="twitter:title" content="{{ $title }}">
    <meta property="twitter:description" content="{{ $desc }}">
    <meta property="twitter:image" content="{{ $meta_img }}">

    <link rel="icon" type="image/png" href="{{ asset('storage/logo_icon/'.$siteData->favicon) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Hind+Siliguri:300,400,500,600,700">
    <link rel="stylesheet" href="css/app.css">
<link rel="stylesheet" href="css/custom.css">
    {!! $siteData->ggl_analytic !!}
    <style>{{ request()->path() }}</style>
  </head>

  <body>
    <div id="app"></div>
    {!! $siteData->ggl_analytic_ns !!}
    <div class="searchpage_link" style="display: none;">
        <div class="input-group pt-5 pl-3 pr-3">
          <div class="input-group-prepend">
            <span class="input-group-text rounded-0" id="basic-addon1"><i class="fa fa-search" aria-hidden="true"></i></span>
          </div>
          <input type="text" class="form-control rounded-0" placeholder="Search for products, brands, events, articles and more" onkeyup="search($(this).val(),'.searchpage_link .list-group')">
        </div>
        <div class="list-group pl-3 pr-3 border-0">

        </div>

        <button type="button" class="close" onclick="toggleSearch()">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div data-id="app">
      <div class="header_top  {{ Str::startsWith(request()->path(),'the-loft')?'loftheader':'' }}" {{request()->has('nolayout')?'style=display:none':''}}>
          <div class="container">
              <div class="row">
                  {{-- <div class="col-lg-6 d-flex align-items-center d-none d-sm-none d-md-none d-lg-block">
                      <a class="textwelcome">Welcome to {{ $siteData->title }}</a>
                  </div> --}}


                  <div class="col-lg-3 col-md-3 degreeview"><a href="https://www.google.com/maps/@22.5391101,88.3656377,2a,90y,196.69h,68.79t/data=!3m6!1e1!3m4!1s2FLiDum4yucdf900xFHk-w!2e0!7i13312!8i6656" target="_blank" class="view360"> <img src="{{ asset('storage/logo_icon/degree.png') }}"></a>
                    <div class="mob-social sociallink">
                      <button type="button" class="btn btn-default navbar-btn searchbtn" onclick="toggleSearch()">
                              <i class="fa fa-search" aria-hidden="true"></i>
                          </button>
                          <li><a target="_blank" href="{{ $siteData->facebook }}"><i class="fa fa-facebook"></i></a></li>
                          {{-- <li><a target="_blank" href="{{ $siteData->twitter }}"><i class="fa fa-twitter"></i></a></li> --}}
                          <li><a target="_blank" href="{{ $siteData->instagram }}"><i class="fa fa-instagram"></i></a></li>

                    </div>
                  </div>


                  <div class="col-lg-9 col-md-9 float-right top-phone">
                      <div class="search_cont" style="display: none;"></div>
                      <form id="searchbutton">


                          <i class="fa fa-search" aria-hidden="true"></i>
                          <input type="search" placeholder="Search" onkeyup="search($(this).val(),'.search_cont')"   onfocus="$('.search_cont').html('').show()" onblur="$(this).val('');">
                      </form>
                      <ul class="sociallink float-right">
                        <li>
                          <a href="https://questmall.in/cms/quest/www/index.html" target="_blank" class="callno"> Quest Service Desk</a>
                        </li>
                        <li>
                          <a href="tel:917605056766" class="callno"><i class="fa fa-phone" aria-hidden="true"></i> Pick Up/Porter</a>
                        </li>
                        <button type="button" class="btn btn-default navbar-btn searchbtn dsk" onclick="toggleSearch()">
                              <i class="fa fa-search" aria-hidden="true"></i>
                          </button>
                          <li class="dsk"><a target="_blank" href="{{ $siteData->facebook }}"><i class="fa fa-facebook"></i></a></li>
                          {{-- <li><a target="_blank" href="{{ $siteData->twitter }}"><i class="fa fa-twitter"></i></a></li> --}}
                          <li class="dsk"><a target="_blank" href="{{ $siteData->instagram }}"><i class="fa fa-instagram"></i></a></li>
                        
                      </ul>
                  </div>
              </div>
          </div>
      </div>
      <div class="container"  {{request()->has('nolayout')?'style=display:none':''}}>
          <div class="headercenter">
              <div class="row">
                  <div class="col-6 col-md-3 d-flex align-items-center">
                      <a href="https://rpsg.in/" target="_blank"><img src="{{ asset('storage/logo_icon/'.$siteData->companylogo) }}" class="img-fluid logo01" alt="RP-Sanjiv Goenka Group"></a>
                  </div>
                  <div class="col-6 col-md-3 offset-md-6">
                      <a class="logobox" href="">
                          <img src="{{ asset('storage/logo_icon/'.$siteData->logo) }}" class="img-fluid float-right logo02" alt="{{ $siteData->title }}">
                      </a>
                  </div>
              </div>
          </div>
      </div>
      <div class="mega-menu {{ Str::startsWith(request()->path(),'the-loft')?'menucolor2':'' }}"  {{request()->has('nolayout')?'style=display:none':''}}>
          <div class="container">
              <div class="wsmenucontainer clearfix">
                  <div class="overlapblackbg"></div>
                  <div class="wsmobileheader clearfix">
                      <a id="wsnavtoggle" class="animated-arrow"><span></span></a>
                  </div>
                  <div class="header">
                      <!--Main Menu HTML Code-->
                      <nav class="wsmenu clearfix">
                        <a href="">
                          <img src="{{ asset('storage/logo_icon/'.$siteData->flogo) }}" class="img-fluid mobilequestlogo d-block d-sm-block d-md-block d-lg-none" alt="Responsive image">
                        </a>
                          <ul class="mobile-sub wsmenu-list">
                            @foreach($menuList as $value)
                              @if($value->parent_id == 0)
                              <li>
                                @if($menuList->where('parent_id',$value->id)->count() > 0)
                                @foreach($menuList as $v)
                                @if($v->parent_id == $value->id && $v->link == Request::segment(1))
                                @php
                                $active = 'active';
                                @endphp
                                @endif
                                @endforeach
                                  <a class="{{ isset($active)?$active:'' }}" href="javascript:void(0)">{{ $value->menu }} <i class="wsmenu-arrow fa fa-angle-down"></i></a>
                                  <ul class="wsmenu-submenu">
                                    @foreach($menuList as $v)
                                      @if($v->parent_id == $value->id)
                                      <li><a class="{{ $v->link == Request::segment(1)?'active':'' }}" href="{{ $v->link }}">{{ $v->menu }}</a></li>
                                      @endif
                                    @endforeach
                                  </ul>
                                @else
                                  <a class="{{ $value->link == Request::segment(1)?'active':'' }}" href="{{ $value->link }}">{{ $value->menu }}</a>
                                @endif
                              </li>

                              @endif
                              @php
                              unset($active);
                              @endphp
                            @endforeach

                            <li><a href="https://the-wardrobe.in/" target="_blank"> The-Wardrobe </a></li>

                          </ul>

                           
                      </nav>
                  </div>
              </div>
          </div>
      </div>

      @yield('content')



      <div class="footer  {{ Str::startsWith(request()->path(),'the-loft')?'fotercolor2':'' }}"  {{request()->has('nolayout')?'style=display:none':''}}>
          <div class="container">
              <div class="row">
                  <div class="col-lg-3 col-md-6 col-6">
                      <h6 class="textqoicklink float-left w-100">Quick links</h6>
                      <ul class="quicklink">
                        @foreach($fmenuList as $key=>$value)
                          @if($key+1 <= $fmenuList->count()/2)
                          <li class="{{ $key+1 == $fmenuList->count()/2?'last':'' }}"><a href="{{ $value->link }}">{{ $value->menu }}</a></li>
                          @endif
                        @endforeach
                      </ul>
                  </div>
                  <div class="col-lg-3 col-md-6 col-6">
                      <ul class="quicklink" id="quicklink">
                          @foreach($fmenuList as $key=>$value)
                            @if($key+1 > $fmenuList->count()/2)
                            <li class="{{ $key+1 == $fmenuList->count()?'last':'' }}"><a href="{{ $value->link }}">{{ $value->menu }}</a></li>
                            @endif
                        @endforeach
                      </ul>
                  </div>
                  <div class="col-lg-3 col-md-6">
                      <h6 class="apptext">DOWNLOAD APP</h6>
                      <div class="row">
                          <div class="col-lg-12 col-md-12 text-center">
                              <a target="_blank" href="{{ $siteData->android_app }}" class="googleapplink"><img id="footer_android_app_link" src="images/googlepayicon.png" class="img-fluid googlepayicon" alt="Responsive image"></a>
                              <a target="_blank" href="{{ $siteData->ios_app }}" class="googleapplink"><img id="footer_ios_app_link" src="images/appstoreicon.png" class="img-fluid appstoreicon" alt="Responsive image"></a>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-3 col-md-6 contacttext text-left">
                      <h6 class="querytext">FOR QUERY</h6>
                      <p><a href="{{ $siteData->google_map }}" target="_blank"><i class="fa fa-map-marker fa-fw" aria-hidden="true"></i>  {{ $siteData->address }}</a></p>
                      <p><a href="tel:{{ $siteData->phone }}"><i class="fa fa-phone fa-fw" aria-hidden="true"></i>  {{ $siteData->phone }}</a></p>
                      <p><a href="mailto:{{ $siteData->email }}"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i>  {{ $siteData->email }}</a></p>
                  </div>
              </div>
          </div>
      </div>
      <div class="footerlast text-center  {{ Str::startsWith(request()->path(),'the-loft')?'f_lastcolor':'' }}"  {{request()->has('nolayout')?'style=display:none':''}}>
          <div class="container">
              <p class="mb-0">© {{date('Y')}} Quest Properties India Ltd. All Rights Reserved | Site Maintained by<a href="https://greenreeflive.com/" target="_blank"><!-- <span>b</span> -->
                
                <img src="./images/green-new-logo23.png" class="footer-brand" alt="..." style="background: #fff; border-radius: 50%; width: 26px;">

              </a></p>
          </div>
      </div>
    </div>


    <div class="modal fade" id="dealModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body deals_cont p-0">
                    <div class="card border-0 p-0">
                        <img src="./images/dealsbg2.jpg" class="card-img-top rounded-0" alt="...">
                        <div class="d_cont p-3">
                            <h6 class="mb-0 float-left"></h6>
                            <h6 class="mb-0 float-right" style="color: #bb141c;"></h6>
                        </div>
                        <div class="card-body pt-0 pb-3 pl-3 pr-3">
                            <span class="card-title"><b></b></span><br>
                        </div>
                        <p class="text-center mb-3 b_cont"><a href="deals" class="r_more">VIEW ALL DEALS</a></p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="gotop_button d-block d-md-none d-lg-none">
      <a href="#" id="scroll">
        <i class="fa fa-arrow-up" aria-hidden="true"></i>
      </a>
    </div>

    <script src="js/app.js"></script>
    <script>
      $('#dealModal').on('hidden.bs.modal',function(event) {
        $('body').removeAttr('style')
      });
      $(document).click(function(event) {
        /* Act on the event */
        $('.search_cont').html('').hide()
      });
      $('.search_cont').click(function(event) {
        event.stopPropagation()
      });

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      function showDeal(img,store,desc,date){
          $('#dealModal img').attr('src',img);
          $('#dealModal h6.float-left').text(store);
          $('#dealModal h6.float-right').text(date);
          $('#dealModal .card-title>b').text(desc);
          $('#dealModal').modal('show');
          $('body').css("overflow","hidden")
      }

      function toggleSearch() {
        $('.searchpage_link').toggle()
        if($('.searchpage_link').css('display') == "block"){
        	$('body,html').css("overflow","hidden")
        }else{
        	$('body,html').css("overflow","auto")
        }
      }

      var t;
      function search(query, cont) {
        $(cont).html('');
        clearTimeout(t);
        t = setTimeout(function(){
          $.ajax({
            beforeSend: function(){
              $('#searchbutton i,.searchpage_link i').removeClass('fa-search').addClass('fa-refresh fa-spin')
            },
            complete: function(){
              $('#searchbutton i,.searchpage_link i').addClass('fa-search').removeClass('fa-refresh fa-spin')
            },
            url: 'ajax/search/'+query,
            type: 'get',
            success:function(data){
              data = JSON.parse(data);
              $('.search_cont').html('').show()
              $.each(data, function(index, val) {
                 $(cont).append($('<a href="'+val['link']+'" class="list-group-item list-group-item-action p-2 pl-3 pr-3 rounded-0">'+(val['name']?val['name']:val['title'])+'<br><small class="text-muted">'+val['type']+'</small></a>'))
              });
            }
          });
        }, 1000)

      }

      $(document).ready(function(){
          $(window).scroll(function(){
              if ($(this).scrollTop() > 150 && $(this).scrollTop() < $(document).height() - $(this).height() - 220) {
                  $('#scroll').fadeIn();
              } else {
                  $('#scroll').fadeOut();
              }
          });
          $('#scroll').click(function(){
              $("html, body").animate({ scrollTop: 0 }, 600);
              return false;
          });
      });

      // var c1 = new Hammer($('#carouselExampleFade2')[0]);
      // c1.on('swipe', function(ev) {
      //   if(ev.direction == 4){
      //     $('#carouselExampleFade2').carousel('prev')
      //   }else if(ev.direction == 2){
      //     $('#carouselExampleFade2').carousel('next')
      //   }
      // });

      // var c2 = new Hammer($('#carouselExampleFade3')[0]);
      // c2.on('swipe', function(ev) {
      //   if(ev.direction == 4){
      //     $('#carouselExampleFade3').carousel('prev')
      //   }else if(ev.direction == 2){
      //     $('#carouselExampleFade3').carousel('next')
      //   }
      // });

      // var c3 = new Hammer($('#carouselExampleFade4')[0]);
      // c3.on('swipe', function(ev) {
      //   if(ev.direction == 4){
      //     $('#carouselExampleFade4').carousel('prev')
      //   }else if(ev.direction == 2){
      //     $('#carouselExampleFade4').carousel('next')
      //   }
      // });

      // var c4 = new Hammer($('#carouselExampleFade6')[0]);
      // c4.on('swipe', function(ev) {
      //   if(ev.direction == 4){
      //     $('#carouselExampleFade6').carousel('prev')
      //   }else if(ev.direction == 2){
      //     $('#carouselExampleFade6').carousel('next')
      //   }
      // });


      var c0 = new Hammer($('.overlapblackbg')[0]);
      c0.on('swipe', function(ev) {
        if(ev.direction == 2){
          $('#wsnavtoggle').click()
        }
      });


      function showFrescoHandler(){
        var c1 = new Hammer($('.fr-window')[0]);
        c1.on('swipe', function(ev) {
          if(ev.direction == 4){
            $('.fr-side-previous').click()
          }else if(ev.direction == 2){
            $('.fr-side-next').click()
          }
        });
      }

$('.top-resturent .owl-carousel').owlCarousel({
        loop:true,
        margin:30,
        autoplay:true,
        autoplayTimeout:5000,
        responsiveClass:true,
        responsive:{
            0:{
                items:2,
                nav:true
            },
            600:{
                items:3,
                nav:false
            },
            1000:{
                items:5,
                nav:true,
                loop:true
            }
        }
    })
$('#app-use .owl-carousel').owlCarousel({
      loop:true,
      margin:30,
      autoplay:true,
        autoplayTimeout:5000,
      responsiveClass:true,
      responsive:{
          0:{
              items:1,
              nav:true
          },
          600:{
              items:3,
              nav:false
          },
          1000:{
              items:3,
              nav:true,
              loop:true
          }
      }
  })

    </script>
    <style type="text/css">
      .degreeview img{
        margin-left: 38px;

    background: #d0ad68;
    padding: 1px 38px;
    border-radius: 5px;
      }

     @media (max-width: 767px) and (min-width: 360px){
        
      .top-phone{
      margin-top: -28px;
      }

      .degreeview img{
        margin-left: 7px;
      }
        .degreeview{
          z-index: 9999999;
          width: 30%;
        }
       }
    </style>
  </body>
</html>