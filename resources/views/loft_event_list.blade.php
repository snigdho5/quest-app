@extends('layout.master',compact('metaData'))
@section('content')

<div id="pageBody">
    <div class="container pt-lg-5 pt-4 pb-lg-5 pb-4">
        <div class="row d-flex justify-content-end">
            <div class="col-lg-6 col-md-8 mb-4">
                <form action="" class="loftfilter mob_space">
                    <div class="input-group input-group-lg rounded-0">
                      <div class="input-group-prepend">
                        <label class="input-group-text pl-0" for="inputGroupSelect01" style="color: #6e2842; background: none; border: none;">Filter Events By</label>
                      </div>
                      <select class="form-control filterSearch rounded-0" name="type">
                        <option value="all" selected>All Events</option>
                        <option {{ request()->type=="current"?'selected':'' }} value="current">Current Events</option>
                        <option {{ request()->type=="upcoming"?'selected':'' }} value="upcoming">Upcoming Events</option>
                        <option {{ request()->type=="past"?'selected':'' }} value="past">Past Events</option>
                        </select>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary border-0 rounded-0 text-white ml-1" id="inputGroupFileAddon04" style="background-color: #6e2842; height: 48px; margin-top: 1px;">GO</button>
                      </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row deals_cont" id="deals_cont">
            @if($eventsData->count()==0)
            <div class="col-sm-12"><h4 class="mt-5 mb-5 text-center text-muted">Sorry! We couldn't find any event.<br><small>Please try again with different preferences.</small></h4></div>
            @endif
            @foreach($eventsData as $key=>$value)
            <div class="col-lg-4 col-md-6 col-12 mb-4 loftcard_box">
                <span class="border-bottom"></span>
                <a href="the-loft/events/{{ $value->slug }}">
                    <div class="card border-0">
                        <img src="{{ asset('storage/event/thumb/'.$value->sq_image) }}" class="card-img-top rounded-0" alt="..." style="border:thin solid rgba(0,0,0,0.1)">
                        <div class="card-body pl-0 p-0 pt-lg-1 pt-2">
                            <span class="card-title"><b>{{ $value->title }}</b></span><br>
                        </div>
                        <div class="d_cont pt-1">
                            <h6 class="mb-0 float-left" style="color: #bb141c;">{{ $value->start_date->format('dS M, Y') }}</h6>
                            <h6 class="mb-0 float-right" style="color: #bb141c;">{{ $value->end_date->format('dS M, Y') }}</h6>
                        </div>
                        <small class="text-muted mt-2">{!! str_limit(strip_tags($value->content),100) !!}</small>
                    </div>
                </a>
            </div>
            @endforeach

        </div>
        <p class="loadingText text-center" style="display: none"><i class="fa fa-spin fa-refresh fa-fw"></i> Loading...</p>

    </div>
</div>

<script type="text/javascript">
    var comp = false;
    var working = false;
    var total = {{ $eventsCount }};
    var current = {{ $eventsData->count() }};
    function loadMore(){
        if((total > current) && !working){
            working = true;
            $.ajax({
                url: 'ajax/loadEvents{!! $_SERVER['QUERY_STRING']?'?'.$_SERVER['QUERY_STRING']:''!!}',
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
@endsection