
    <div class="container">
        {{-- <div class="row d-flex justify-content-end">
            <div class="col-lg-6 col-md-8 mb-4">
                <div class="input-group input-group-lg rounded-0">
                    <div class="input-group-prepend">
                        <label class="input-group-text pl-0" for="inputGroupSelect01" style="color: #02a68e; background: none; border: none;">Filter Deals By</label>
                    </div>
                    <select class="form-control filterSearch rounded-0">
                        <option value="all" selected>All Category</option>
                        @foreach ($blogCat as $key => $value)
                        <option {{ request()->category==str_slug($value->title)?'selected':'' }} value="{{ str_slug($value->title) }}">{{ $value->title }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary border-0 rounded-0 text-white ml-1" type="button" id="inputGroupFileAddon04" style="background-color: #0aaa92; height: 48px; margin-top: 1px;">GO</button>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row b_cont d-flex justify-content-center">
            @if($blogData->count()==0)
            <div class="col-sm-12"><h4 class="mt-5 mb-5 text-center text-muted">Sorry! We couldn't find any article.<br><small>Please try again with different preferences.</small></h4></div>
            @endif
            @foreach ($blogData as $key => $value)
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <span class="border-bottom"></span>
                <div class="card rounded-0 border-0">
                    <div>
                        <a href="qreview/{{ $value->slug }}">
                            <img class="img-fluid w-100" src="{{ asset('storage/qreview/thumb/'.$value->sq_image) }}">
                        </a>
                    </div>
                    <div class="page_header">
                        <h6 class="text-uppercase mb-0 text-white">{{ date('dS M, y',strtotime($value->post_time)) }}</h6>
                        <ul class="mb-0">
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ url('qreview/' . $value->slug) }}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="https://twitter.com/intent/tweet?url={{ url('qreview/' . $value->slug) }}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="http://pinterest.com/pin/create/button/?url={{ url('qreview/' . $value->slug) }}&media={{ asset('storage/blog/thumb/'.$value->sq_image) }}" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title"><a href="qreview/{{ $value->slug }}">{{ $value->title }}</a></h5>
                        {{-- <p class="card-text">{!! str_limit(strip_tags($value->content),70) !!}</p> --}}
                        <p class="card-text">by 
                            @php 
                            $author = explode(',', $value->author);
                            foreach ($author as $key => $v) {
                              $author[$key]= get_anydata('qauthor',$v,'title');
                            }
                          @endphp
                          {{ implode(', ',$author) }}
                        </p>
                        <a href="qreview/{{ $value->slug }}" class="text-uppercase r_more">Read More</a>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
        {{ $blogData->links() }}
    </div>
<script>
    window.onload = function(){
        $('.filterSearch').selectpicker();
    }
</script>
