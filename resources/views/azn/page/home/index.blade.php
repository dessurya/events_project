@extends('azn.layout.base')

@section('title')
Home
@endsection

@push('link')
<style type="text/css">
	#single-slick .slick-item .img{
        height: 525px;
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

	#webiste-slick .weekly2-single .weekly2-img .img{
    	height: 260px;
    	background-position: center;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        border-radius: 7px;
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

  .blog_item .blog_item_img .img{
      height: 260px;
      background-position: center;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        border-radius: 7px;
    }

    .blog_item_img .blog_item_date.color-1{
      background-color: #fc0000;
    }
    .blog_item_img .blog_item_date.color-2{
      background-color: #2f00fc;
    }
    .blog_item_img .blog_item_date.color-3{
      background-color: #fc008d;
    }
    .blog_item_img .blog_item_date.color-4{
      background-color: #fca400;
    }
    .blog_item_img .blog_item_date.color-5,
    .blog_item_img .blog_item_date.color-6{
      background-color: #625454;
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

@if(count($MasterWebsite) > 3)
<script type="text/javascript">
	$('#webiste-slick').slick({
		dots: true,
        infinite: true,
        speed: 500,
        arrows: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay:true,
        autoplaySpeed:1250,
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
				<div class="col-lg-12">
					<div class="trending-top mb-35">
						<div id="single-slick" class="trend-top-img">
							@foreach($MainSlider as $slide)
							<div class="slick-item">
								<div class="img d-block w-100" style="background-image: url({{ asset($slide->picture) }});" title="{{ $slide->name }}"></div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<section class="whats-news-area pt-50 pb-20">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="row d-flex justify-content-between">
          <div class="col-lg-3 col-md-3">
            <div class="section-tittle mb-30">
              <h3>Our Events</h3>
            </div>
          </div>
          <div class="col-lg-9 col-md-9">
            <div class="properties__button">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active" id="nav-ongoing-tab" data-toggle="tab" href="#nav-all" role="tab" aria-controls="nav-all" aria-selected="false">All</a>
                  <a class="nav-item nav-link" id="nav-ongoing-tab" data-toggle="tab" href="#nav-ongoing" role="tab" aria-controls="nav-ongoing" aria-selected="false">On Going</a>
                  <a class="nav-item nav-link" id="nav-upcoming-tab" data-toggle="tab" href="#nav-upcoming" role="tab" aria-controls="nav-upcoming" aria-selected="false">Upcoming</a>
                  <a class="nav-item nav-link" id="nav-past-tab" data-toggle="tab" href="#nav-past" role="tab" aria-controls="nav-past" aria-selected="false">Past</a>
                </div>
              </nav>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                <div class="row">
                  @foreach($eventAll as $event)
                  @include('azn.componen.event-card', ['event'=>$event])
                  @endforeach
                </div>
              </div>
              <div class="tab-pane fade" id="nav-ongoing" role="tabpanel" aria-labelledby="nav-ongoing-tab">
                <div class="row">
                  @foreach($eventGetOnGoing as $event)
                  @include('azn.componen.event-card', ['event'=>$event])
                  @endforeach
                </div>
              </div>
              <div class="tab-pane fade" id="nav-upcoming" role="tabpanel" aria-labelledby="nav-upcoming-tab">
                <div class="row">
                  @foreach($eventGetUpComming as $event)
                  @include('azn.componen.event-card', ['event'=>$event])
                  @endforeach
                </div>
              </div>
              <div class="tab-pane fade" id="nav-past" role="tabpanel" aria-labelledby="nav-past-tab">
                <div class="row">
                  @foreach($eventGetPast as $event)
                  @include('azn.componen.event-card', ['event'=>$event])
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@if(count($MasterWebsite) > 0)
@include('azn.componen.our-website',['MasterWebsite'=>$MasterWebsite])
@endif

@if(!empty($InterfaceConfig['about_us']))
<div class="about-area pt-50 pb-50 gray-bg mb-0">
	<div class="container text-center">
    <?php
    // {!! $InterfaceConfig['about_us'] !!}
    ?>
    <img src="{{ asset('images/lOGO.png') }}" alt="">
	</div>
</div>
@endif
@endpush