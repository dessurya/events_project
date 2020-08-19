@extends('site._layouts.base')

@section('title')
Our Event
@endsection

@push('link')
<style>
    .container-fluid{
        padding : 20px 0;
    }
    .container{
        padding: 10px 6px;
    }
    .card-img-top{
        width: 100%;
        height:380px;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }
    h3{
        margin: 20px 0;
    }
</style>
@endpush

@push('script')
@endpush

@push('content')
<div class="container-fluid">
    <h2 class="text-center">Our Event</h2>

    <div class="container">
        <h3 class="text-center">On Going</h3>
        <div class="row">
            @foreach($events['ongoing'] as $event)
            @include('site._componen.event-card', ['event'=>$event])
            @endforeach
        </div>
        <a href="{{ route('site.event.ongoing') }}" class="btn btn-outline-primary btn-block">View More</a>
    </div>

    <div class="container">
        <h3 class="text-center">Upcomming</h3>
        <div class="row">
            @foreach($events['upcomming'] as $event)
            @include('site._componen.event-card', ['event'=>$event])
            @endforeach
        </div>
        <a href="{{ route('site.event.upcomming') }}" class="btn btn-outline-primary btn-block">View More</a>
    </div>

    <div class="container">
        <h3 class="text-center">Past</h3>
        <div class="row">
            @foreach($events['past'] as $event)
            @include('site._componen.event-card', ['event'=>$event])
            @endforeach
        </div>
        <a href="{{ route('site.event.past') }}" class="btn btn-outline-primary btn-block">View More</a>
    </div>

</div>
@endpush