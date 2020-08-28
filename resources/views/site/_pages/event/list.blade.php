@extends('site._layouts.base')

@section('title')
{{ $config['title'] }}
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
        background-size: 100% 100%;
        background-repeat: no-repeat;
    }
</style>
@endpush

@push('script')
<script>
    $(document).on('click', '#loadMore', function(){
        event.preventDefault();
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
<div class="container-fluid">
    <h2 class="text-center">{{ $config['title'] }}</h2>

    <div class="container">
        <div id="render" class="row">
            @foreach($config['data'] as $event)
            @include('site._componen.event-card', ['event'=>$event])
            @endforeach
        </div>
        <a id="loadMore" data-page="1" href="{{ route($config['route']) }}" class="btn btn-outline-primary btn-block">Load More</a>
    </div>
</div>
@endpush