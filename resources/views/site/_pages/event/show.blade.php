@extends('site._layouts.base')

@section('title')
{{ $data->title }}
@endsection

@push('link')
<style>
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
        padding : 10px 0;
        grid-column-start: 1;
        grid-column-end: 3;
    }

    #MainContent .img{
        height: 490px;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    #EventOGU{
        background: #fff;
    }

    .column{
        padding : 0px 20px 20px;
    }

    .registration{
        padding : 20px 10px;
    }
    #title{
        padding : 5px 0;
    }

    @media (max-width: 812px) { /* Mobile landscape and potrait */
        .grid-container{
            display: block;
            grid-template-columns: none;
        }
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

    function fill_form(data) {
        $('form .input').removeAttr('readonly').attr('required', 'true');
        $('form').data('form','store');
        $.each(data, function(key, val){
            $('form').find('[name='+key+']').val(val);
        });
        $('form').find('[name=username]').removeAttr('required').attr('readonly', 'true');
    }
</script>
@endpush

@push('script.responsePostData')
if(data.fill_form) { fill_form(data.fill_form_data); }
@endpush

@push('content')
<div class="grid-container">
    <div id="MainContent" class="container">
        <div id="title">
            <h2 class="text-center">{{ Str::title($data->title) }}</h2>
        </div>
        <div class="img d-block w-100" title="{{ $data->title }}"
        @if(!empty($data->picture))
        style="background-image : url({{ $data->picture }})"
        @else
        style="background-image : url({{ asset('images/manandapple.jpg') }})"
        @endif
        ></div>
        <div class="column">
            <p class="card-text text-center"><small class="text-muted">
                @if(!empty($data->start_registration) and !empty($data->end_registration))Registration : {{ $data->start_registration.' - '.$data->end_registration }} | @endif<span class="badge {{ $data->status_id == 2 ? 'badge-danger' : 'badge-info'}}">{{ $data->status }}</span> | {{ $data->start_event.' - '.$data->end_event }} : Activity
            </small></p>
            <div class="text-center">
                @foreach($website as $item)
                <a href="{{ empty($item->website->url) ? '#' : $item->website->url }}" class="badge badge-success">{{ $item->website->name }}</a>
                @endforeach
            </div>
            <div>{!! $data->description !!}</div>
            <div>{!! $data->terms_and_conditions !!}</div>
            <hr>
            @if($data->event_id == 1)
            <div>@include('site._componen.event-leaderboard', ['participants'=>$param['participants']])</div>
            @elseif($data->event_id == 2)
            <div>@include('site._componen.event-coupon', ['participants'=>$param['participants']])</div>
            @endif
        </div>
    </div>
    <div id="EventOGU">
        {{ App\Http\Controllers\Site\HomeController::eventTabsList() }}

        <div class="registration">
            <h5>Registration Form</h5>
            @include('site._componen.event-registration')
        </div>
    </div>
</div>
@endpush