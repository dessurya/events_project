@extends('azn.layout.base')

@section('title')
Our Event
@endsection

@push('link')
<style type="text/css">
	#list-index .blog_item .blog_item_img .img{
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
@endpush

@push('script.responsePostData')
if(data.change_page == true){ change_page(data.change_page_val); }
@endpush

@push('content')
<div>
    @foreach($events as $event)
	<div class="container mb-35">
		<div class="section-tittle text-center mb-30">
			<h3>{{ $event['title'] }}</h3>
		</div>

		<div id="list-index" class="row">
			@foreach($event['events'] as $row)
            @include('azn.componen.event-card', ['event'=>$row])
            @endforeach
		</div>

		<a href="{!! route($event['route']) !!}" class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn">View More</a>
	</div>
    @endforeach
</div>
@endpush