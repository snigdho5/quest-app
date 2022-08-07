
    <div class="container">
        <div class="filterbtn">
            <div class="row">
                <div class="formgroup col-8 d-block d-md-none d-lg-none pr-0">
                    <div class="input-group">
                        <input type="text" class="form-control rounded-0" id="storeSearch" placeholder="Type store name or product types" onkeyup="$('.storeSearch').val($(this).val())">
                        <div class="input-group-append">
                            <button onclick="$('#searchForm')[0].submit()" class="btn btn-secondary searchbutton rounded-0" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <button type="button" class="btn btn-filter w-100" onclick="$('#AAA, body,html').toggleClass('open');$('.btn-filter').toggle()"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> Filter</button>
                    <button type="button" class="btn btn-filter w-100" onclick="$('#AAA, body,html').toggleClass('open');$('.btn-filter').toggle()" style="display:none;"><i class="fa fa-close" aria-hidden="true"></i> Close</button>
                </div>
            </div>
        </div>
        <div class="allcategory">
            <div class="row">
                <div class="col-md-4 formbox storefilter" id="AAA">
                    <div class="position-sticky" style="top: 25px;">
                        <form action="" id="searchForm">
                            <div class="input-group mb-4 storesearch">
                                <input name="search" type="text" class="form-control rounded-0 storeSearch" id="storeSearch" placeholder="Type store name or product type" value="{{ request()->search }}">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary searchbutton rounded-0" ><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <select name="type" class="form-control filterSearch mb-4 rounded-0" onchange="this.form.submit()" {{ (request()->floor != '' && request()->floor != 'all') ? 'disabled' : '' }}>
                                <option selected value="all">Filter by type</option>
                                @foreach ($typeData as $key => $value)
                                <option {{ request()->type==$value->id?'selected':'' }} value="{{ $value->id }}">{{ $value->title }}</option>
                                @endforeach
                            </select>

                            <select name="floor" class="form-control filterSearch mb-4 rounded-0" onchange="this.form.submit()" {{ (request()->type != '' && request()->type != 'all') ? 'disabled' : '' }} >
                                <option selected value="all">Filter by floor</option>
                                <option {{ request()->floor=="Basement"?'selected':'' }}>Basement</option>
                                <option {{ request()->floor=="Ground Floor"?'selected':'' }}>Ground Floor</option>
                                <option {{ request()->floor=="First Floor"?'selected':'' }}>First Floor</option>
                                <option {{ request()->floor=="Second Floor"?'selected':'' }}>Second Floor</option>
                                <option {{ request()->floor=="Third Floor"?'selected':'' }}>Third Floor</option>
                            </select>
                            <input type="hidden" name="category" id="cat" value="{{ request()->category }}">
                        </form>
                        <h4 class="text4">Filter by</h4>
                        <ul class="storeslist">
                            <!-- <li>
                                @if(request()->category == 'deals')
                                <a style="color:#d0ad68" href="javascript:void(0)" onClick="$('#cat').val('')[0].form.submit()">Deals <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                @else
                                <a href="javascript:void(0)" onClick="$('#cat').val('deals')[0].form.submit()">Deals <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                @endif
                            </li> -->
                            @foreach ($catData as $key => $value)
                            <li class="{{ $catData->count() == $key+1?'last':'' }}">
                                @if(request()->category == $value->id)
                                <a style="color:#d0ad68" href="javascript:void(0)" onClick="$('#cat').val('')[0].form.submit()">{{ $value->title }} <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                @else
                                <a href="javascript:void(0)" onClick="$('#cat').val({{ $value->id }})[0].form.submit()">{{ $value->title }} <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-8" id="dealsbox">
                    <div class="row">
                        @if($storeData->count()==0)
                        <div class="col-sm-12"><h4 class="mt-5 mb-5 text-center text-muted">Sorry! We couldn't find any store.<br><small>Please try again with different preferences.</small></h4>

                        <div class="morelink mt-3 d-inline-block d-flex justify-content-center" id="morelink">
                            <a href="{{ Request::url() }}" class="shopinglink"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
                            <a href="{{ Request::url() }}" class="pagelink" id="pagelink04">Go Back</a>
                        </div>

                        </div>
                        @endif
                        @foreach ($storeData as $key => $value)
                        <div class="col-lg-4 col-md-6 col-6 mb-4">
                            <a href="stores/{{ str_slug($value->name) }}" title="{{ $value->name }}">
                                <div class="dealsbox">
                                    <span class="dealbg" style="background-image: url({{ asset('storage/store_banner/thumb/'.$value->banner()->where('featured','1')->first()['image']) }})">
                                        <div class="whitecolor">
                                            <img src="{{ asset('storage/store/actual/'.$value->logo) }}" class="img-fluid logobg" alt="{{ $value->name }}">
                                        </div>
                                        @if ($value->deals()->where([['active','1'],['image','!=',''],['beacon_type','0'],['post_time','<=',date("Y-m-d H:i:s")]])->whereDate('end_date','>', date('Y-m-d'))->count() > 0)
                                        <div class="imagetext">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="45px" height="45px" viewBox="0 0 45 45" enable-background="new 0 0 45 45" xml:space="preserve">
                                                <polygon fill="#FBAE2F" points="0,0.003 0,44.997 21.997,35.834 45,45 45,0 " />
                                            </svg>
                                            <span>DEALS</span>
                                        </div>
                                        @endif
                                    </span>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <p class="loadingText text-center" style="display: none"><i class="fa fa-spin fa-refresh fa-fw"></i> Loading...</p>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">
    var comp = false;
    var working = false;
    var total = {{ $storeCount }};
    var current = {{ $storeData->count() }};
    function loadMore(){
        if((total > current) && !working){
            working = true;
            $.ajax({
                url: 'ajax/loadStore{!! $_SERVER['QUERY_STRING']?'?'.$_SERVER['QUERY_STRING']:''!!}',
                type: 'POST',
                data: {count: current},
                success: function(data){
                    $('#dealsbox>.row').append($(data))
                    current = $('#dealsbox>.row>div').length;
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
                if($(window).scrollTop() + $(window).height() > ($('#dealsbox>.row>div').last().offset().top + $('#dealsbox>.row>div').last().height() + 150)){
                    $('.loadingText').show()
                    loadMore()
                }
            }
        });
    }


</script>


