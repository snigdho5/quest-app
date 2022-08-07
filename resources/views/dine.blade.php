
    <div class="container">
        <div class="collectionbg  pb-5">
            <div class="row collection">
                <div class="col-md-10 col-12">
                    <div class="inner-banerbg" style=" background: url('{{ asset('storage/store_banner/actual/'.$dineData->banner()->where('featured','1')->first()['image']) }}');"></div>
                    <div class="contentcollec d-block d-md-none d-lg-none d-sm-none">
                        <h2><b>{{ $dineData->name }}</b></h2>
                    </div>
                </div>
                <div class="col-md-2 col-12">
                    <div class="veromodalogo"  title="{{ $dineData->name }}">
                        <img src="{{ asset('storage/store/actual/'.$dineData->logo) }}" class="img-fluid" alt="{{ $dineData->name }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="winterbgboxs pb-5 pt-sm-0 pt-md-0 pt-lg-0 pt-3">
            <div class="row">
                @if($dineDeals->count())
                <div class="{{ $dineBanner->count()?'col-md-3':'col-md-12' }} pb-5 winterbox">
                    <h3><b>CURRENT</b> <span style="color: #d0ad68;">DEALS</span></h3>
                    <div class="owl-carousel owl-theme winterslider" id="rightarrow">
                        @foreach($dineDeals as $key=>$value)
                        <div class="item" style="border:thin solid rgba(0,0,0,.2)">
                            <a href="javascript:void(0)" onclick='showDeal("{{ asset('storage/store_deal/actual/'.$value->image) }}","{{ $value->store['name'] }}","{{ $value->description }}","{{ $value->start_date->format('dS M, y') }} - {{ $value->end_date->format('dS M, y') }}")'>
                                <img src="{{ asset('storage/store_deal/thumb/'.$value->image) }}" class="img-fluid" alt="{{ $value->description }}">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @if($dineBanner->count()-1 > 0)
                <div class="{{ $dineDeals->count()?'col-md-9':'col-md-12' }}">
                    <div class="winterbox">
                        <h3><b>DINE</b> <span style="color: #d0ad68;">GALLERY</span></h3>
                        <div class="owl-carousel owl-theme winterslider c1" id="rightarrow">
                            @foreach($dineBanner as $key=>$value)
                            @if($value->featured == 0)
                            <div class="item">
                                <a href="{{ asset('storage/store_banner/actual/'.$value->image) }}" class="fresco" data-fresco-group="gallery"  data-fresco-group-options="ui: 'inside', onShow: showFrescoHandler">
                                    <img src="{{ asset('storage/store_banner/thumb/'.$value->image) }}" class="img-fluid" alt="...">
                                </a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="veromodabox pt-lg-5 pt-4 pb-lg-5 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-12 col-md-12">
                    <h1 class="d-none d-md-block d-lg-block"><b>{{ $dineData->name }}</b></h1>
                    <div>{!! $dineData->description !!}</div>
                    <div class="morelink">
                        <a href="{{ asset('storage/store/actual/'.$dineData->location) }}" data-lightbox="example-set" class="shopinglink"><i class="fa fa-map-marker" aria-hidden="true"></i></a>
                        <a href="{{ asset('storage/store/actual/'.$dineData->location) }}" data-lightbox="example-set" class="pagelink" id="pagelink05">GET DIRECTION</a>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-12 col-md-12 categorybox">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="media d-flex align-items-center">
                                <span><i class="fa fa-user" aria-hidden="true"></i></span>
                                <div class="media-body">
                                    <h5 class="mt-0">DINE MANAGER</h5>
                                    <h6>{{ $dineData->manager }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media d-flex align-items-center">
                                <span><i class="fa fa-user" aria-hidden="true"></i></span>
                                <div class="media-body">
                                    <h5 class="mt-0">MANAGER PHONE</h5>
                                    @php
                                        $mp = explode(' / ', $dineData->manager_phone);
                                    @endphp
                                    @foreach ($mp as $p)
                                    <h6><a href="tel:{{ $p }}">{{ $p }}</a></h6>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media d-flex align-items-center">
                                <span><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                                <div class="media-body">
                                    <h5 class="mt-0">DINE TIMINGS</h5>
                                    <h6>{{ $dineData->timing }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media d-flex align-items-center">
                                <span><i class="fa fa-phone" aria-hidden="true"></i></span>
                                <div class="media-body">
                                    <h5 class="mt-0">PHONE NUMBER</h5>
                                    @foreach($dineData->contactno as $v)
                                    <h6><a href="tel:{{ $v->phone }}">{{ $v->phone }}</a></h6>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media d-flex align-items-center">
                                <span><i class="fa fa-sitemap" aria-hidden="true"></i></span>
                                <div class="media-body">
                                    <h5 class="mt-0">CATEGORY</h5>
                                    <h6>{{ $dineData->type->title }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media d-flex align-items-center">
                                <span><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                <div class="media-body">
                                    <h5 class="mt-0">EMAIL</h5>
                                    @foreach($dineData->contactemail as $v1)
                                    <h6><a href="mailto:{{ $v1->email }}">{{ $v1->email }}</a></h6>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="media d-flex align-items-center">
                                <span><i class="fa fa-desktop" aria-hidden="true"></i></span>
                                <div class="media-body">
                                    <h5 class="mt-0">WEBSITE</h5>
                                    <h6><a target="_blank" href="{{ $dineData->website }}">{{ $dineData->website }}</a></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="clientbox pt-5 pb-lg-5 pb-0">
            <div class="row">
                @if($otherDines->count())
                <div class="col-md-12">
                    <h3><b>You may</b> <span>also like</span></h3>
                    <div class="owl-carousel owl-theme clientslider" id="rightarrow">
                        @foreach($otherDines as $key=>$value)
                        <div class="item" style="border:thin solid rgba(0,0,0,.2)">
                            <a href="dines/{{ str_slug($value->name) }}" title="{{ $value->name }}">
                                <img src="{{ asset('storage/store/actual/'.$value->logo) }}" class="img-fluid" alt="{{ $value->name }}">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>


        <div class="morelink mt-5 mb-4 d-inline-block d-flex justify-content-center  d-lg-none d-md-none d-sm-none" id="morelink">
            <a href="dines" class="shopinglink"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
            <a href="dines" class="pagelink" id="pagelink04">Go Back</a>
        </div>
    </div>


<script>
    window.onload = function(){
        $('.winterslider:not(.c1)').owlCarousel({
            loop:false,
            margin:30,
            nav:true,
            navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
            dots:false,
            autoplay:true,
            autoplayTimeout:4000,
            autoplayHoverPause:true,
            items:1
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
            @if($dineDeals->count())
            items:3,
            @else
            responsive:{0:{items:2},600:{items:3},1000:{items:4}}
            @endif
        })
        $('.clientslider').owlCarousel({
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