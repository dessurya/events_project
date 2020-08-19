@extends('site._layouts.base')

@section('title')
Home
@endsection

@push('link')
<style type="text/css">
    .carousel .carousel-inner .carousel-item .img{
        height: 538px;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .grid-container{
        display: grid;
        grid-template-columns: auto auto 400px;
        grid-gap: 0px;
        padding: 0px;
    }

    .grid-container > div{
        padding: 0px;
    }

    #MainContent{
        grid-column-start: 1;
        grid-column-end: 3;
    }

    #EventOGU{
        background: #fff;
    }

    .container > div{
        padding : 10px 20px;
    }
</style>
@endpush

@push('script')
@endpush

@push('content')
<div class="grid-container">
    <div id="MainContent">
        <div id="carouselMainSlider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach($MainSlider as $slide)
                <div class="carousel-item">
                    <div class="img d-block w-100" style="background-image: url({{ asset($slide->picture) }});" title="{{ $slide->name }}"></div>
                </div>
                @endforeach
            </div>
        </div>
        <div id="interface" class="container">
            <div id="about_us">{!! $InterfaceConfig['about_us'] !!}</div>
            <div id="footer">{!! $InterfaceConfig['footer'] !!}</div>
        </div>
    </div>
    <div id="EventOGU">
        {{ App\Http\Controllers\Site\HomeController::eventTabsList() }}
    </div>
</div>
@endpush