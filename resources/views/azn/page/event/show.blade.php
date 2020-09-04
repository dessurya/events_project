@extends('azn.layout.base')

@section('title')
{{ $data->title }}
@endsection

@push('link')
<style type="text/css">
	.section-padding{
		padding-top: 40px;
		padding-bottom: 40px;
	}
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
</style>
@endpush

@push('script')
<script>
    $(document).on('submit', 'form#registration', function(){
        let input = {};
        $.each($(this).find('.input'), function(){
            input[$(this).attr('name')] = $(this).val();
        });
        input['form'] = $(this).data('form');
        pnotifyConfirm({
            "title" : "Warning",
            "type" : "info",
            "text" : "Are You Sure Submit This Form?",
            "formData" : false,
            "data" : input,
            "url" : $(this).attr('action')
        });
		event.preventDefault();
    });

    $(document).on('submit', 'form#getCoupon', function(){
        let input = {};
        $.each($(this).find('.input'), function(){
            input[$(this).attr('name')] = $(this).val();
        });
        postData(input,$(this).attr('action'));
		event.preventDefault();
    });

    function fill_form(data) {
        $('form#registration #otherInput').show();
        $('form#registration .input').removeAttr('readonly').attr('required', 'true');
        $('form#registration').data('form','store');
        $.each(data, function(key, val){
            $('form').find('[name='+key+']').val(val);
        });
        $('form#registration').find('[name=username]').removeAttr('required').attr('readonly', 'true');
        $('form#registration').find('[name=website]').removeAttr('required').attr('disabled', 'disabled');
    }
</script>
@endpush

@push('script.responsePostData')
if(data.fill_form) { fill_form(data.fill_form_data); }
@endpush

@push('content')
<section class="blog_area single-post-area section-padding">
	<div class="container">
		<div class="section-tittle text-center mb-30">
			<h3>{{ Str::title($data->title) }}</h3>
		</div>
		<div class="row">
			<div class="col-lg-8 posts-list">
				<div class="single-post">
					<div class="feature-img text-center">
						<img class="img-fluid" title="{{ $data->title }}" alt="{{ $data->title }}"
						@if(!empty($data->picture))
				        src="{{ asset($data->picture) }}"
				        @else
				        src="{{ asset('images/manandapple.jpg') }}"
				        @endif
						>
					</div>
					<div class="blog_details">
						@if(count($website) > 0)
						<ul class="blog-info-link mt-3 mb-4">
							@foreach($website as $item)
							<li>
								<a href="{{ empty($item->website->url) ? '#' : $item->website->url }}">{{ $item->website->name }}</a>
							</li>
							@endforeach
						</ul>
						@endif
						@if(!empty($data->description))
						<div class="mb-20">{!! $data->description !!}</div>
						@endif
			            <div class="container gray-bg mb-20 pt-25 pb-20">{!! $data->terms_and_conditions !!}</div>
			            @if($data->event_id == 1)
			            <div class="board">
			            	@include('azn.componen.event-leaderboard', ['participants'=>$param['participants'],'participants_username_status_id'=>$param['participants_username_status_id']])
			            </div>
			            @elseif($data->event_id == 2)
			            <div class="board">
			            	@include('azn.componen.event-coupon', ['MasterWebsite'=>$MasterWebsite])
			            </div>
			            @endif
					</div>
				</div>
			</div>

			<div class="col-lg-4">
				<div class="blog_right_sidebar">
					
					<aside class="single_sidebar_widget">
						<h3 class="widget_title">{{ $data->status }}</h3>
						@if(!empty($data->start_registration))
						<h6>Section Registration On : </h6>
						<p>
							{{ (new Carbon\Carbon($data->start_registration))->format('F, d Y').' - '.(new Carbon\Carbon($data->end_registration))->format('F, d Y') }}
						</p>
						@endif
						@if(!empty($data->start_event))
						<h6>Start On : </h6>
						<p>
							{{ (new Carbon\Carbon($data->start_event))->format('F, d Y').' - '.(new Carbon\Carbon($data->end_event))->format('F, d Y') }}
						</p>
						@endif
					</aside>

					@if(count($param['ongoing']))
					@include('azn.componen.event-show-widget',['date'=>'end','param'=>$param['ongoing'],'widget_title'=>'On Going Event'])
					@endif

					@if(count($param['upcomming']))
					@include('azn.componen.event-show-widget',['date'=>'start','param'=>$param['upcomming'],'widget_title'=>'Up Comming Event'])
					@endif

					@if(count($param['past']))
					@include('azn.componen.event-show-widget',['date'=>'end','param'=>$param['past'],'widget_title'=>'Past Event'])
					@endif

					@if(in_array($data->event_id, [1,2]) and in_array($data->status_id, [2,3,4]) and $data->registration_status_id == 1)
					<aside class="single_sidebar_widget evnt_recent">
						<h3 class="widget_title">Registration Form</h3>
			            @include('azn.componen.event-registration')
					</aside>
					@endif
				</div>
			</div>
		</div>
	</div>
</section>
@endpush