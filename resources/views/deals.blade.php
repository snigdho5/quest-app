
    <div class="container">
        <div class="row d-flex justify-content-end">
            <div class="col-lg-6 col-md-8 mb-4">
                <form action="" class="mob_space">
                    <div class="input-group input-group-lg rounded-0">
                      <div class="input-group-prepend">
                        <label class="input-group-text pl-0" for="inputGroupSelect01" style="color: #d0ad68; background: none; border: none;">Filter Deals By</label>
                      </div>
                      <select class="form-control filterSearch rounded-0" name="type">
                        <option value="all" selected>All Categories</option>
                        @foreach ($typeData as $key => $value)
                        <option {{ request()->type==$value->id?'selected':'' }} value="{{ $value->id }}">{{ $value->title }}</option>
                        @endforeach
                        </select>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary border-0 rounded-0 text-white ml-1" id="inputGroupFileAddon04" style="background-color: #d0ad68; height: 48px; margin-top: 1px;">GO</button>
                      </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row deals_cont" id="deals_cont">
            @if($dealsData->count()==0)
            <div class="col-sm-12"><h4 class="mt-5 mb-5 text-center text-muted">Sorry! We couldn't find any deal.<br><small>Please try again with different preferences.</small></h4>
                <div class="morelink mt-3 d-inline-block d-flex justify-content-center" id="morelink">
                    <a href="{{ Request::url() }}" class="shopinglink"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
                    <a href="{{ Request::url() }}" class="pagelink" id="pagelink04">Go Back</a>
                </div>
            </div>
            @endif
            @foreach($dealsData as $key=>$value)
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <span class="border-bottom"></span>
                <a href="javascript:void(0)">
                    <div class="card border-0">
                        <img src="{{ asset('storage/store_deal/thumb/'.$value->image) }}" class="card-img-top rounded-0" alt="..." style="border:thin solid rgba(0,0,0,0.1)">
                        <div class="d_cont pt-3">
                            <h6 class="mb-0 float-left">{{ $value->store['name'] }}</h6>
                            <h6 class="mb-0 float-right" style="color: #bb141c;">{{ $value->start_date->format('dS M, y') }} - {{ $value->end_date->format('dS M, y') }}</h6>
                        </div>
                        <div class="card-body pl-0 p-0 pt-lg-1 pt-2">
                            <span class="card-title"><b>{{ $value->description }}</b></span><br>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach

        </div>
        <p class="loadingText text-center" style="display: none"><i class="fa fa-spin fa-refresh fa-fw"></i> Loading...</p>

    </div>

<script type="text/javascript">
    var comp = false;
    var working = false;
    var total = {{ $dealsCount }};
    var current = {{ $dealsData->count() }};
    function loadMore(){
        if((total > current) && !working){
            working = true;
            $.ajax({
                url: 'ajax/loadDeals{!! $_SERVER['QUERY_STRING']?'?'.$_SERVER['QUERY_STRING']:''!!}',
                type: 'POST',
                data: {count: current},
                success: function(data){
                    $('#deals_cont').append($(data))
                    current = $('#deals_cont>div').length;
                    $('.loadingText').hide()
                    working = false;
                    if(total == current) comp = true
                }
            })
        }else $('.loadingText').hide()
    }
    window.onload = function(){
        $('.filterSearch').selectpicker();

        $(window).scroll(function(event) {
            if (!comp){
                if($(window).scrollTop() + $(window).height() > ($('#deals_cont>div').last().offset().top + $('#deals_cont>div').last().height() + 150)){
                    $('.loadingText').show()
                    loadMore()
                }
            }
        });
    }

</script>