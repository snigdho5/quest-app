<div class="container">
    <div class="row blogpage">
        <div class="col-lg-{{ $otherData->count()? 8:12 }} col-md-12">
            <div class="blog_details">
                <h2 class="text-uppercase mt-0" style="color: #d0ad68;">{{ $galleryData->title }}</h2>
                <p class="text-muted"><i class="fa fa-calendar fa-fw" aria-hidden="true"></i> {{ $galleryData->date->format('dS F, Y') }}</p>
                <div class="gallery">
                    <div class="">
                        <div class="gallery-grids">
                            <div class="w3ls-gallery-grids">
                                <div class="row justify-content-left">
                                    @foreach($galleryImages as $key=>$value)
                                    <div class="col-md-4 col-6 gallery-grids-left-subr mb-4">
                                        <div class="gallery-grid gallery01">
                                            <a class="example-image-link fresco" href="{{ asset('storage/gallery/actual/'.$value->image) }}" data-fresco-group="gallery" data-fresco-group-options="ui: 'inside', onShow: showFrescoHandler" data-fresco-caption="{{ $value->title }}">
                                                <img src="{{ asset('storage/gallery/thumb/'.$value->image) }}" class="img-fluid w-100" alt="{{ $value->title }}" />
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
            </div>
            <div class="clearfix"></div>
        </div>
        @if($otherData->count())
        <div class="col-lg-4 col-md-12 mt-lg-0 mt-5">
            <div class="Categories">

                <h3 class="text-uppercase mb-lg-3 mb-0">Other <span>Albums</span></h3>
                @foreach($otherData as $key=>$value)
                <a href="gallery/{{ $value->slug }}" class="media border-bottom pt-3 pb-3" style="text-decoration: none">
                    <img src="{{ asset('storage/gallery/thumb/'.$value->images()->where('active','1')->first()->image) }}" class="align-self-center mr-3 border" alt="..." style="width:80px">
                    <div class="media-body">
                        <h6 class="mt-0">{{ $value->title }}</h6>
                        <p class="mb-0"><i class="fa fa-calendar" aria-hidden="true"></i> {{ date('dS M, Y',strtotime($value->date)) }}</p>
                    </div>
                </a>
                @endforeach

            </div>
        </div>
        @endif
    </div>
</div>
