<div class="newslist">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @foreach($newsData as $key=>$value)
                <div class="row news d-flex align-items-center">
                    <div class="col-lg-2 col-md-2 col-3 text-center">
                        <p class="mb-0">{{ date('d',strtotime($value->post_time)) }}</p>
                        <span>{{ date('M Y',strtotime($value->post_time)) }}</span>
                    </div>
                    <div class="col-lg-8 col-md-8 col-9">
                        <a href="{{ $value->link }}" target="_blank"><h4 class="mb-0 news4text">{{ $value->title }}</h4></a>
                        <a href="{{ $value->link }}" target="_blank" class="text-uppercase d-block d-md-none d-lg-none">Read More</a>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <a href="{{ $value->link }}" target="_blank" class="text-uppercase d-none d-md-block d-lg-block">Read More</a>
                    </div>
                </div>
                @endforeach
                <br>
                {{ $newsData->links() }}
            </div>
            <div class="col-lg-4 mt-lg-0 mt-5">
                <div class="Categories">
                    <h3 class="text-uppercase mb-lg-3 mb-0"><span>BLOGS</span></h3>
                    @foreach($latestData as $key=>$value)
                    <a href="blogs/{{ $value->slug }}" class="media border-bottom pt-3 pb-3" style="text-decoration: none">
                        <img src="{{ asset('storage/blog/thumb/'.$value->sq_image) }}" class="align-self-center mr-3 border" alt="..." style="width:80px">
                        <div class="media-body">
                            <h6 class="mt-0">{{ $value->title }}</h6>
                            <p class="mb-0"><i class="fa fa-calendar" aria-hidden="true"></i> {{ date('dS M, Y',strtotime($value->post_time)) }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
