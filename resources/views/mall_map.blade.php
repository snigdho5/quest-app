
    <div class="container">
        <div class="row d-flex justify-content-center">
            @foreach ($mapData as $key => $value)
            <div class="col-lg-4 col-md-6 mt-4">
                <a href="{{ asset('storage/map/actual/'.$value->image) }}" class="fresco" data-fresco-group="gallery"  data-fresco-group-options="ui: 'inside', onShow: showFrescoHandler" data-fresco-caption="{{ $value->title }}">
                    <div class="mallmap">
                        <img src="{{ asset('storage/map/actual/'.$value->image) }}" class="img-fluid" alt="{{ $value->title }}">
                        <div class="map-content d-none d-md-block d-lg-block">
                            <h3 class="maptitle">{{ $value->title }}</h3>
                        </div>

                        <ul class="icon">
                            <li>Explore</li>
                        </ul>
                    </div>
                    <div class="m_content d-block d-md-none d-lg-none">
                        <h3 class="m_title mb-0">{{ $value->title }}</h3>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>