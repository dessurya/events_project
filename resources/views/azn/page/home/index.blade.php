@extends('azn.layout.base')

@section('title')
Home
@endsection

@push('link')
<style type="text/css">
	#single-slick .slick-item .img{
        height: 425px;
        background-position: center;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        border-radius: 7px;
    }
    .trending-area .trending-main .trand-right-single{
    	padding-bottom: 0px;
    }

    #upcomming-slick .weekly-single .weekly-img .img{
    	height: 260px;
    	background-position: center;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        border-radius: 7px;
    }
</style>
@endpush

@push('script')
<script type="text/javascript">
	$('#single-slick').slick({
		autoplay: true,
		autoplaySpeed: 3120,
		fade: true,
		dots: false,
		arrows: false,
		slidesToShow: 1,
		slidesToScroll: 1
	});

	$('#upcomming-slick').slick({
		dots: true,
        infinite: true,
        speed: 500,
        arrows: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay:true,
        initialSlide: 3,
        loop:true,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,
              dots: false,
            }
          },
          {
            breakpoint: 991,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
	});
</script>
@endpush

@push('content')
<div class="trending-area fix">
	<div class="container">
		
		<div class="trending-main">
			<div class="row">
				<div class="col-lg-8">
					<div class="trending-top mb-30">
						<div id="single-slick" class="trend-top-img">
							@foreach($MainSlider as $slide)
							<div class="slick-item">
								<div class="img d-block w-100" style="background-image: url({{ asset($slide->picture) }});" title="{{ $slide->name }}"></div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="section-tittle">
						<h3>On Going Event</h3>
					</div>
					@foreach(App\Http\Controllers\Azn\HomeController::eventGetOnGoing(4) as $key => $row)
					<div id="eventGetOnGoing" class="trand-right-single d-flex">
						<div class="trand-right-cap">
							<span class="color{{ $key%2 == 0 ? 2 : 3 }}">Do Date : {{ $row->start_event.' - '.$row->end_event }}</span>
							<h4><a href="{{ route('azn.event.show', ['type'=>base64_encode($row->event_id),'encode'=>base64_encode($row->id)]) }}">
								{{ Str::title($row->title).' - '.$row->event }}
							</a></h4>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>

		<div class="weekly-news-area pt-50">
			<div class="container">
				<div class="weekly-wrapper">
					<div class="row">
						<div class="col-lg-12">
							<div class="section-tittle mb-50">
								<h3>Up Comming Event</h3>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div id="upcomming-slick" class="dot-style d-flex dot-style">
								@foreach(App\Http\Controllers\Azn\HomeController::eventGetUpComming(6) as $key => $row)
								<div class="weekly-single">
									<div class="weekly-img">
										<div class="img d-block w-100" title="{{ asset($row->title) }}"
										@if(!empty($row->picture))
								        style="background-image : url({{ $row->picture }})"
								        @else
								        style="background-image : url({{ asset('images/manandapple.jpg') }})"
								        @endif
										></div>
									</div>
									<div class="weekly-caption">
										<span class="color{{ $row->event_id }}">{{ $row->event }} - {{ $row->status }}</span>
										<h4><a href="{{ route('azn.event.show', ['type'=>base64_encode($row->event_id),'encode'=>base64_encode($row->id)]) }}">{{ $row->title }}</a></h4>
									</div>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="about-area pt-50">
			<div class="container">
				{!! $InterfaceConfig['about_us'] !!}
			</div>
		</div>

	</div>
</div>
@endpush