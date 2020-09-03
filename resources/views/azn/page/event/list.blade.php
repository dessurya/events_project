@extends('azn.layout.base')

@section('title')
{{ $config['title'] }}
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
<script type="text/javascript">
	$(document).on('click', '#loadMore', function(){
        var input = {};
        input['page'] = parseInt($(this).data('page'))+1;
        var search = window.location.href.split('?')
        if (search.length == 2) {
            search = search[1].split('=')[1];
            if (search.length > 0) {
                input['search'] = search;
            }
        }
        postData(input, $(this).attr('href'));
        return false;
    });

    function change_page(val) {
        var page = parseInt($('#loadMore').data('page'));
        if(page == val){
            $('#loadMore').remove();
        }else{
            $('#loadMore').data('page',val);
        }
        
    }
</script>
@endpush

@push('script.responsePostData')
if(data.change_page == true){ change_page(data.change_page_val); }
@endpush

@push('content')
<div>
	<div class="container mb-35">
		<div class="section-tittle text-center mb-30">
			<h3>{{ $config['title'] }}</h3>
		</div>

		<div id="list-index" class="row">
			@foreach($config['data'] as $event)
            @include('azn.componen.event-card', ['event'=>$event])
            @endforeach
		</div>

		<a id="loadMore" data-page="1" href="{{ route($config['route']) }}" class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn">Load More</a>
	</div>
</div>
@endpush