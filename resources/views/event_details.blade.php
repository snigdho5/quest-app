
    <div class="container d-none">
        <div class="row blogpage">
            <div class="col-md-10 col-10">
                <div class="inner-banerbg" style=" background: url('{{ asset('storage/event/actual/'.$eventData->image) }}');"></div>
            </div>
            <div class="col-md-2 col-2">
                <div class="blogcont">
                    <h2 class="text-uppercase mb-0">{{ $eventData->start_date->format('dS M Y') }} <br><span class="text-muted"><b>to</b></span><br> {{ $eventData->end_date->format('dS M Y') }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="event_details pt-5 pb-lg-3 pb-0">
                    <h1 style="color:#d0ad68">{{ $eventData->title }}</h1>
                    <p class="">{{ $eventData->start_date->format('dS M Y') }} <span class="text-muted">to</span> {{ $eventData->end_date->format('dS M Y') }}</p>
                    {!! $eventData->content !!}
                </div>
                @if($eventBanner->count() > 0)
                <div class="gallery mb-5">
                    <div class="container">
                        <div class="gallery-grids">
                            <div class="w3ls-gallery-grids">
                                <div class="row justify-content-center">
                                    @foreach($eventBanner as $key=>$value)
                                    <div class="col-md-3 col-6 gallery-grids-left-subr mb-4">
                                        <div class="gallery-grid gallery01">
                                            <a class="example-image-link fresco" href="{{ asset('storage/event_gallery/actual/'.$value->image) }}" data-fresco-group="gallery" data-fresco-group-options="ui: 'inside', onShow: showFrescoHandler" data-fresco-caption="{{ $value->title }}">
                                                <img src="{{ asset('storage/event_gallery/thumb/'.$value->image) }}" class="img-fluid w-100" alt="{{ $value->title }}" />
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row blogpage">

            <div class="col-12 mb-4">
                <div class="related_article">
                    <h3 class="text-uppercase mb-0">Other <span>events</span></h3>
                </div>
                <div class="owl-carousel owl-theme articleslider mt-lg-4 mt-3" id="rightarrow">
                    @foreach($otherData as $key=>$value)
                    <div class="item border-right">
                        <a class="media" href="events/{{ $value->slug }}" style="text-decoration: none">
                            <img src="{{ asset('storage/event/thumb/'.$value->sq_image) }}" class="align-self-center mr-3 border" alt="..."  style="width:100px">
                            <div class="media-body">
                                <h6 class="mt-0">{{ $value->title }}</h6>
                                <p class="mb-0"><i class="fa fa-calendar" aria-hidden="true"></i> {{ $value->start_date->format('dS M, Y') }} to {{ $value->end_date->format('dS M, Y') }}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

<script>
  window.onload = function(){
    $('.articleslider').owlCarousel({
        loop:true,
        margin:10,
        dots:false,
        nav:true,
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:3
            }
        }
    })
  }
</script>