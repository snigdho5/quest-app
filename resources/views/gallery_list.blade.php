
    <div class="container">
        <div class="row deals_cont" id="deals_cont">
            @foreach($galleryData as $key=>$value)
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <span class="border-bottom"></span>
                <a href="gallery/{{ $value->slug }}">
                    <div class="card border-0">
                        <img src="{{ asset('storage/gallery/thumb/'.$value->images()->where('active','1')->first()->image) }}" class="card-img-top rounded-0" alt="..." style="border:thin solid rgba(0,0,0,0.1)">
                        <div class="card-body pl-0 p-0 pt-lg-1 pt-2">
                            <span class="card-title"><b>{{ $value->title }}</b></span><br>
                        </div>
                        <div class="d_cont pt-1">
                            <h6 class="mb-0 float-left" style="color: #404041;">{{ $value->date->format('dS M, Y') }}</h6>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach

        </div>
        <br>
        {{ $galleryData->links() }}

    </div>
