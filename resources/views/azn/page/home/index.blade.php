@extends('azn.layout.base')

@section('title')
Home
@endsection

@push('link')
<style type="text/css">
	#single-slick .slick-item .img{
		@if(count($eventGetPast) > 0)
        height: 425px;
        @else
        height: 625px;
        @endif
        background-position: center;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        border-radius: 7px;
    }
    @media screen and (max-width: 812px) and (min-width: 528px) {
    	#single-slick .slick-item .img{
    	    	height: 360px;
    	}
    }
    @media (max-width: 528px) {
    	#single-slick .slick-item .img{
    	    	height: 300px;
    	}
    }
    .trending-area .trending-main .trand-right-single{
    	padding-bottom: 0px;
    }

    #upcomming-slick .weekly2-single .weekly2-img .img{
    	height: 260px;
    	background-position: center;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        border-radius: 7px;
    }

    #eventGetOnGoing .single-bottom .trend-bottom-img .img{
    	height: 210px;
    	background-position: center;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        border-radius: 7px;
    }

    #eventGetPast .trand-right-single .trand-right-img .img{
    	width: 120px;
    	height: 100px;
    	background-position: center;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        border-radius: 7px;
    }
    .hover{
    	transition: all .3s ease-out 0s;
    }
    .hover:hover{
    	color: #fc3f00 !important;
    }

    .weekly2-pading{
		padding-top: 60px;
		padding-bottom: 60px;
	}
    @media only screen and (max-width: 1199px) and (min-width: 992px){
		.weekly2-pading{
			padding-top: 60px;
			padding-bottom: 60px;
		}
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
</script>

@if(count($eventGetUpComming) > 3)
<script type="text/javascript">
	$('#upcomming-slick').slick({
		dots: true,
        infinite: true,
        speed: 500,
        arrows: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay:true,
        initialSlide: 0,
        loop:true,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
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
@endif
@endpush

@push('content')
<div class="trending-area fix">
	<div class="container">
		<div class="trending-main">
			<div class="row">
				<div class="col-lg-{{ count($eventGetPast) > 0 ? 8 : 12}}">
					<div class="trending-top mb-35">
						<div id="single-slick" class="trend-top-img">
							@foreach($MainSlider as $slide)
							<div class="slick-item">
								<div class="img d-block w-100" style="background-image: url({{ asset($slide->picture) }});" title="{{ $slide->name }}"></div>
							</div>
							@endforeach
						</div>
					</div>
					@if(count($eventGetOnGoing) > 0)
					<div id="eventGetOnGoing" class="trending-bottom">
						<div class="section-tittle text-center mb-35">
							<h3>
								<a class="hover" href="{{ route('azn.event.ongoing') }}">
									On Going Event
								</a>
							</h3>
						</div>
						<div class="row">
							@foreach($eventGetOnGoing as $key => $row)
							<div class="col-lg-4">
								<div class="single-bottom mb-35">
									<div class="trend-bottom-img mb-30">
										<div class="img d-block w-100" title="{{ asset($row->title) }}"
										@if(!empty($row->picture))
								        style="background-image : url({{ $row->picture }})"
								        @else
								        style="background-image : url({{ asset('images/manandapple.jpg') }})"
								        @endif
										></div>
									</div>
									<div class="trend-bottom-cap">
										<span class="color{{ $key%2 == 0 ? 4 : 1 }}">{{ $row->event }}</span>
										<h4>
											<a href="{{ route('azn.event.show', ['type'=>base64_encode($row->event_id),'encode'=>base64_encode($row->id)]) }}">
												{{ Str::title($row->title) }}
											</a>
										</h4>
										<small class="mb-10">{{ (new Carbon\Carbon($row->start_event))->format('F, d Y') }}</small>
										@if(!empty($row->description))
										<p class="text-justify">{!! Str::words(strip_tags($row->description), 10, '...') !!}</p>
										@endif
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
					@endif
				</div>
				@if(count($eventGetPast) > 0)
				<div id="eventGetPast" class="col-lg-4">
					<div class="section-tittle text-center mb-35">
						<h3>
							<a class="hover" href="{{ route('azn.event.past') }}">
								Past Event
							</a>
						</h3>
					</div>
					@foreach($eventGetPast as $key => $row)
					<div class="trand-right-single d-flex">
						<div class="trand-right-img">
                            <div class="img" title="{{ asset($row->title) }}"
							@if(!empty($row->picture))
					        style="background-image : url({{ $row->picture }})"
					        @else
					        style="background-image : url({{ asset('images/manandapple.jpg') }})"
					        @endif
							></div>
                        </div>
						<div class="trand-right-cap">
							<span class="color{{ $row->event_id }}">{{ $row->event }}</span>
							<h4>
								<a href="{{ route('azn.event.show', ['type'=>base64_encode($row->event_id),'encode'=>base64_encode($row->id)]) }}">
									{{ Str::title($row->title) }}
								</a>
							</h4>
							<small class="mb-10">{{ (new Carbon\Carbon($row->start_event))->format('F, d Y') }}</small>
							@if(!empty($row->description))
							<p class="text-justify">{!! Str::words(strip_tags($row->description), 10, '...') !!}</p>
							@endif
						</div>
					</div>
					@endforeach
				</div>
				@endif
			</div>
		</div>
	</div>
</div>

@if(count($eventGetUpComming) > 0)
<div class="weekly2-news-area  weekly2-pading">
	<div class="container">
		<div class="weekly2-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<div class="section-tittle mb-50">
						<h3>
							<a class="hover" href="{{ route('azn.event.past') }}">
								Up Comming Event
							</a>
						</h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div id="upcomming-slick" class="dot-style d-flex dot-style">
						@foreach($eventGetUpComming as $key => $row)
						<div class="weekly2-single">
							<div class="weekly2-img">
								<div class="img d-block w-100" title="{{ asset($row->title) }}"
								@if(!empty($row->picture))
						        style="background-image : url({{ $row->picture }})"
						        @else
						        style="background-image : url({{ asset('images/manandapple.jpg') }})"
						        @endif
								></div>
							</div>
							<div class="weekly2-caption">
								<span class="color{{ $row->status_id }}">{{ $row->event }}</span>
								<h4>
									<a href="{{ route('azn.event.show', ['type'=>base64_encode($row->event_id),'encode'=>base64_encode($row->id)]) }}">
										{{ $row->title }}
									</a>
								</h4>
								<small class="mb-10">{{ (new Carbon\Carbon($row->start_event))->format('F, d Y') }}</small>
								@if(!empty($row->description))
								<p class="text-justify">{!! Str::words(strip_tags($row->description), 10, '...') !!}</p>
								@endif
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@else

@endif

@if(!empty($InterfaceConfig['about_us']))
<div class="about-area pt-50 pb-50 gray-bg mb-0">
	<div class="container">
		{!! $InterfaceConfig['about_us'] !!}
	</div>
</div>
@endif
@endpush