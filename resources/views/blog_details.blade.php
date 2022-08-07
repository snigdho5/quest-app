<div class="container">
    <div class="row blogpage">
        <div class="col-lg-8 col-md-12">
            <div class="blog_details">
                <img src="{{ asset('storage/blog/actual/'.$blogData->image) }}" class="img-fluid" alt="Responsive image">
                <div class="blog_cont">
                    <span class="float-left text-uppercase text-white">{{ date('dS F Y',strtotime($blogData->post_time)) }}</span>
                    {{-- <span class="float-right text-uppercase text-white">Beauty</span> --}}
                </div>
                <h1 class="text-uppercase mt-3">{{ $blogData->title }}</h1>
                {!! $blogData->content !!}
                <ul class="d-flex align-items-center socialbtn">
                    <li class="share"><i class="fa fa-share" aria-hidden="true"></i></li>
                    <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ url('blogs/' . $blogData->slug) }}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="https://twitter.com/intent/tweet?url={{ url('blogs/' . $blogData->slug) }}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    {{-- <li><a href="http://pinterest.com/pin/create/button/?url={{ url('blogs/' . $blogData->slug) }}&media={{ asset('storage/blog/thumb/'.$blogData->sq_image) }}" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li> --}}
                </ul>
            </div>
            <div class="clearfix"></div>
            @if($relatedData->count())
            <hr>
            <div class="related_article">
                <h3 class="text-uppercase mb-0">related <span>articles</span></h3>
            </div>
            <div class="owl-carousel owl-theme articleslider mt-lg-4 mt-3" id="rightarrow">
                @foreach($relatedData as $key=>$value)
                <div class="item border-right">
                    <a class="media" href="blogs/{{ $value->slug }}" style="text-decoration: none">
                        <img src="{{ asset('storage/blog/thumb/'.$value->sq_image) }}" class="align-self-center mr-3 border" alt="..."  style="width:100px">
                        <div class="media-body">
                            <h6 class="mt-0">{{ $value->title }}</h6>
                            <p class="mb-0"><i class="fa fa-calendar" aria-hidden="true"></i> {{ date('dS M, Y',strtotime($value->post_time)) }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="col-lg-4 col-md-12 mt-lg-0 mt-5">
            @if($deals->count() > 0)
        	<div class="latest_deals">
        		<h3 class="text-uppercase mb-3">Latest <span>Deals</span></h3>
        		<div class="positionbox" id="topmobilebanner1">
                    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                        <div class="carousel-inner">
                        	@foreach ($deals as $key => $value)
                            <div class="carousel-item {{ $key==0?'active':'' }}">
                                <a href="javascript:void(0)" onclick='showDeal("{{ asset('storage/store_deal/actual/'.$value->image) }}","{{ $value->store['name'] }}","{{ $value->description }}","{{ $value->start_date->format('dS M, y') }} - {{ $value->end_date->format('dS M, y') }}")' style="background-image: url({{ asset('storage/store_deal/thumb/'.$value->image) }}); background-color: #ccc;"></a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="dealHover">
                        <a href="deals"><p>There {{$deals->count()==1?'is':'are'}} {{$deals->count()}} deal{{$deals->count()>1?'s':''}} awating you</p></a>

                        <div class="morelink mt-3 d-inline-block" id="morelink">
                            <a href="deals" class="shopinglink"><i class="fa fa-shopping-bag" aria-hidden="true"></i></a>
                            <a href="deals" class="pagelink" id="pagelink04">Explore</a>
                        </div>
                    </div>
                </div>
        	</div>
            @endif
            <div class="Categories {{$deals->count()>0 ? 'mt-5' : ''}} position-sticky" style="top:25px;">
                @if($latestData->count())
                <h3 class="text-uppercase mb-lg-2 mb-0">Latest <span>articles</span></h3>
                @foreach($latestData as $key=>$value)
                <a href="blogs/{{ $value->slug }}" class="media border-bottom pt-3 pb-3" style="text-decoration: none">
                    <img src="{{ asset('storage/blog/thumb/'.$value->sq_image) }}" class="align-self-center mr-3 border" alt="..." style="width:80px">
                    <div class="media-body">
                    	<p class="mb-2"><i class="fa fa-calendar" aria-hidden="true"></i> {{ date('dS M, Y',strtotime($value->post_time)) }}</p>
                        <h6 class="mt-0">{{ $value->title }}</h6>
                    </div>
                </a>
                @endforeach
                @endif
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
                items:2
            }
        }
    })
  }
</script>