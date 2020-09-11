@extends('azn.layout.base')

@section('title')
Contact Us
@endsection

@push('link')
<style type="text/css">
	.evnt_recent .img{
		height: 75px;
        background-position: center;
        background-size: 100% 100%;
        background-repeat: no-repeat;
	}
	.board{
		padding-top: 30px;
		padding-bottom: 30px;
	}
	.single-follow .follow-us .follow-social .img{
    	height: 60px;
    	width: 60px;
    	background-position: center;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        border-radius: 7px;
    }
	@media (max-width: 528px) {
		.whats-news-area .single-follow .follow-us, .about-area .single-follow .follow-us, .contact-section .single-follow .follow-us{
			width: 100%;
		}
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
	.weekly2-news-area .weekly2-wrapper .weekly2-single .weekly2-caption span{
      border-radius: 0 7px 0 7px;
      padding: 10px 25px;
      font-size: 18pt;
      color:white;
      border: 2px solid rgba(0,0,0,0);
      box-shadow: 5px 10px 10px gray;
      transition: all 1.11s;
    }
    .weekly2-news-area .weekly2-wrapper .weekly2-single:hover .weekly2-caption span{
      box-shadow: 0px 0px 0px gray;
      color:black;
      border: 2px solid black;
      background: rgba(255,255,255,.9);
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
<section class="about-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 pt-25 pb-50">
				<div class="section-tittle text-center mb-30">
					<h3>Contact Us</h3>
				</div>
				<div class="mb-30">
					{!! $InterfaceConfig !!}
				</div>
				<div class="single-follow">
					<div class="single-box">
						@foreach($contact as $row)
						<div class="follow-us d-flex align-items-center mobile">
							<div class="follow-social">
								<a href="{{ empty($row->url) ? '#' : $row->url }}">
									<div class="img" title="{{ $row->text }}"
									@if(!empty($row->picture))
									style="background-image : url({{ $row->picture }})"
									@else
									style="background-image : url({{ asset('images/manandapple.jpg') }})"
									@endif
									></div>
								</a>
							</div>
							<div class="follow-count">  
								<a href="{{ empty($row->url) ? '#' : $row->url }}">
									<span class="hover">
										{{ $row->text }}
									</span>
								</a>
							</div>
						</div>
						@endforeach
					</div>
				</div>

				@if(count($MasterWebsite) > 0)
				@include('azn.componen.our-website',['MasterWebsite'=>$MasterWebsite])
				@endif
			</div>
			<div class="col-lg-4">
				<div class="blog_right_sidebar">
					@foreach($params as $param)
					@if(count($param['event']) > 0)
					@include('azn.componen.event-show-widget',['date'=>$param['date'],'param'=>$param['event'],'widget_title'=>$param['title']])
					@endif
					@endforeach
				</div>
			</div>
		</div>
	</div>
</section>
@endpush