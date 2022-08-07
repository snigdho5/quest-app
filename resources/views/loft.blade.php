
    <div class="container">
        <div class="row loftbgbox pb-3">
            <div class="col-md-10 col-10">
                <div class="">
                    <div id="carouselExampleFade6" class="carousel slide carousel-fade" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @if($eventData->count() == 1)
                            <li data-target="#carouselExampleFade6" data-slide-to="0" class="active"></li>
                            @endif
                            @foreach($bannerData as $key=>$value)
                            <li data-target="#carouselExampleFade6" data-slide-to="{{$eventData->count()==0 ? $key:$key + 1}}" class="{{($eventData->count() == 0) && ($key==0)?'active':''}}"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner">
                            @if($eventData->count() == 1)
                            <div class="carousel-item active">
                                <a href="the-loft/events/{{ $eventData[0]->slug }}" style="background-color: #ccc;">
                                    <img src="{{ asset('storage/event/actual/'.$eventData[0]->image) }}" alt="" class="img-fluid">
                                </a>
                            </div>
                            @endif
                            @foreach($bannerData as $key=>$value)
                            <div class="carousel-item {{($eventData->count() == 0) && ($key==0)?'active':''}}">
                                <a style="background-color: #ccc;">
                                    <img src="{{ asset('storage/loft_banner/actual/'.$value->image) }}" alt="" class="img-fluid">
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @if($eventData->count() == 1)
                        {{-- <div class="loftcontent">
                            <p class="mb-0">{{ strip_tags($eventData[0]->content) }}</p>
                        </div> --}}
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-2">
                <div class="loftlogo">
                    <img src="images/loftlogo.png" class="img-fluid" alt="Responsive image">
                </div>
            </div>
        </div>
        <div class="upcomingevents">
            <div class="row">
                @if($upcomingData->count() > 0)
                <div class="{{ $pastData->count()?'col-md-6':'col-md-12' }} mt-lg-5 mt-4">
                    <div class="winterbox">
                        <h3 style="color: #8d908f;">UPCOMING <span>EVENTS</span></h3>
                        <div class="owl-carousel owl-theme eventslider" id="rightarrow">
                            @foreach($upcomingData as $key=>$value)
                            <div class="item border">
                                <a href="the-loft/events/{{ $value->slug }}">
                                    <img src="{{ asset('storage/event/thumb/'.$value->sq_image) }}" class="img-fluid" alt="{{ $value->title }}">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                @if($pastData->count() > 0)
                <div class="{{ $upcomingData->count()?'col-md-6':'col-md-12' }} mt-lg-5 mt-4">
                    <div class="winterbox">
                        <h3 style="color: #8d908f;">PAST <span>EVENTS</span></h3>
                        <div class="owl-carousel owl-theme eventslider" id="rightarrow">
                            @foreach($pastData as $key=>$value)
                            <div class="item border">
                                <a href="the-loft/events/{{ $value->slug }}">
                                    <img src="{{ asset('storage/event/thumb/'.$value->sq_image) }}" class="img-fluid" alt="{{ $value->title }}">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <p class="text-center mt-5"><a href="the-loft/events" class="viewalllink">VIEW ALL EVENTS</a></p>
        </div>
    </div>

<script>
    window.onload = function(){
        $('.eventslider').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots:false,
            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,

            @if($pastData->count() && $upcomingData->count())
            items:2
            @else
            responsive:{0:{items:2},600:{items:3},1000:{items:4}}
            @endif
        })
    }
</script>
