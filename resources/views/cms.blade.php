@extends('layout.master', compact('metaData'))
@section('content')

<style>p:empty{margin:0 !important;}</style>

<div id="pageBody">
    @if($cmsData->header == '1' && $sub_slug == '')
    <div class="container {{ (request()->page == "" || request()->page == "1")?'':'d-none' }}" {{request()->has('nolayout')?'style=display:none':''}}>
        <div class="row blogpage mt-lg-5 mt-4">
            <div class="col-md-10 col-10">
                <div class="inner-banerbg" style=" background: url('{{ asset('storage/cms/actual/'.$cmsData->image) }}');"></div>
            </div>
            <div class="col-md-2 col-2">
                <div class="blogcont">
                    <h1 class="text-uppercase mb-0">{{ $cmsData->title }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container {{request()->has('nolayout')?'':'d-none'}}">
        <h1 class="text-center pt-3">{{ $cmsData->title }}</h1>
    </div>
    @else
    <div class="container d-none">
        <h1>{{ $cmsData->title }}</h1>
    </div>
    @endif

    <div class="pt-lg-5 pt-4 pb-lg-5 pb-4">
        @foreach($cmsData->content['content'] as $key=>$value)
        <div class="container">{!! $value !!}</div>
        {!! @$cmsData->content['module'][$key] !!}
        @endforeach
    </div>
</div>


@endsection