<style>
    .tagsbox a{
        font-size: 15px;
    }
    .tagsbox a .fa{
        font-size: 13px;
        margin-right: 3px;
        color: #b4b4b4;
    }
   @media screen and (max-width:575px) {
    .blogpage #rightarrow.owl-theme .owl-nav {
    top: -60px;
}
.blog_details h1 {
    font-size: 25px;
}
   }


</style>
<div class="container">
    <div class="row blogpage">
        <div class="col-lg-8 col-md-12">
            <div class="blog_details">
                <img src="{{ asset('storage/qreview/actual/'.$blogData->image) }}" class="img-fluid" alt="Responsive image">
                <div class="blog_cont">
                    <span class="float-left text-uppercase text-white">{{ date('dS F Y',strtotime($blogData->post_time)) }}</span>
                    {{-- <span class="float-right text-uppercase text-white">Beauty</span> --}}
                </div>
                <h1 class="text-uppercase mt-3">{{ $blogData->title }}</h1>
                {!! $blogData->content !!}


               {{--  @if($blogData->gallery->count() > 0)
                    <div class="winterbox pb-5">
                        <h3><b>Q-REVIEW</b> <span style="color: #d0ad68;">GALLERY</span></h3>
                        <div class="owl-carousel owl-theme winterslider c1" id="rightarrow">
                            @foreach($blogData->gallery as $key=>$value)
                            <div class="item">
                                <a href="{{ asset('storage/qreview_gallery/actual/'.$value->image) }}" class="fresco" data-fresco-group="gallery" data-fresco-group-options="ui: 'inside', onShow: showFrescoHandler">
                                    <img src="{{ asset('storage/qreview_gallery/thumb/'.$value->image) }}" class="img-fluid" alt="...">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif --}}

            <ul class="d-flex align-items-center">
                <li class="share"><i class="fa fa-share" aria-hidden="true"></i></li>
                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ url('qreview/' . $blogData->slug) }}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="https://twitter.com/intent/tweet?url={{ url('qreview/' . $blogData->slug) }}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                {{-- <li><a href="http://pinterest.com/pin/create/button/?url={{ url('qreview/' . $blogData->slug) }}&media={{ asset('storage/qreview/thumb/'.$blogData->sq_image) }}" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li> --}}
            </ul>
            </div>
            <div class="clearfix"></div>

            <div class="border-top tagsbox pt-3">
                <strong>TAGS:</strong>
                @php 
                $tagsData = explode(',', $blogData->tags);
                @endphp
                @foreach($tagsData as $value)
                    <a href="{{get_anydata('cms',38,'slug')}}/tag/{{get_anydata('review_tag',$value,'title')}}" class="btn btn-secondary px-2 py-1"><i class="fa fa-hashtag" aria-hidden="true"></i>{{get_anydata('review_tag',$value,'title')}}</a>
                @endforeach
                {{-- <a href="#" class="btn btn-secondary px-2 py-1"><i class="fa fa-hashtag" aria-hidden="true"></i>Tag2</a>
                <a href="#" class="btn btn-secondary px-2 py-1"><i class="fa fa-hashtag" aria-hidden="true"></i>Tag3</a>
                <a href="#" class="btn btn-secondary px-2 py-1"><i class="fa fa-hashtag" aria-hidden="true"></i>Tag4</a>
                <a href="#" class="btn btn-secondary px-2 py-1"><i class="fa fa-hashtag" aria-hidden="true"></i>Tag5</a>
                <a href="#" class="btn btn-secondary px-2 py-1"><i class="fa fa-hashtag" aria-hidden="true"></i>Tag6</a>
                <a href="#" class="btn btn-secondary px-2 py-1"><i class="fa fa-hashtag" aria-hidden="true"></i>Tag7</a>
                <a href="#" class="btn btn-secondary px-2 py-1"><i class="fa fa-hashtag" aria-hidden="true"></i>Tag8</a> --}}
            </div>

            @php 
             $authorData = explode(',', $blogData->author);
            @endphp
            <hr>
            <div class="row mt-4">
                <div class="col-md-12">
                    <h3 class="text-uppercase mb-3">Authors</h3>
                </div>
                @foreach($authorData as $value)
                    <div class="col-md-6 mb-4">
                        <a href="{{get_anydata('cms',38,'slug')}}/author/{{get_anydata('qauthor',$value,'title')}}" style="color:#000; text-decoration: none;">
                          <div class="card p-2 rounded-0">
                            <p class="mb-0"><b><i class="fa fa-user text-secondary mr-2" aria-hidden="true"></i> {{get_anydata('qauthor',$value,'title')}}</b></p>
                            <p class="mb-0"><small>{!! str_limit(strip_tags(get_anydata('qauthor',$value,'content'),10)) !!}</small></p>
                          </div>
                        </a>
                    </div>
                @endforeach
            </div>
            @if($relatedData->count())
            <div class="related_article">
                <h3 class="text-uppercase mb-0">More from <span>QReview</span></h3>
            </div>
            <div class="owl-carousel owl-theme articleslider mt-lg-4 mt-3" id="rightarrow">
                @foreach($relatedData as $key=>$value)
                <div class="item border-right">
                    <a class="media" href="qreview/{{ $value->slug }}" style="text-decoration: none">
                        <img src="{{ asset('storage/qreview/thumb/'.$value->sq_image) }}" class="align-self-center mr-3 border" alt="..."  style="width:100px">
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
                <h3 class="text-uppercase mb-lg-2 mb-0">Latest <span> Blog Articles</span></h3>
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


    $('.winterslider.c1').owlCarousel({
            loop:false,
            margin:30,
            nav:true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots:false,
            autoplay:true,
            autoplayTimeout:4000,
            autoplayHoverPause:true,
            responsive:{0:{items:2},600:{items:3},1000:{items:4}}
        })
  }
</script>