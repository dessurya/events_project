<div class="col-12 col-sm-12 col-md-6">
    <div class="card mb-2">
        <div class="card-img-top" title="{{ $event->title }}"
        @if(!empty($event->picture))
        style="background-image : url({{ $event->picture }})"
        @else
        style="background-image : url({{ asset('images/manandapple.jpg') }})"
        @endif
        ></div>
        <div class="card-body">
            <h5 class="card-title" title="{{ Str::title($event->title) }}">{{ Str::words(Str::title($event->title), 6, '...') }}</h5>
            <p class="card-text" style="height:80px;">
                {!! Str::words(strip_tags($event->description), 20, '...') !!}
            </p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item text-center text-white
                @if($event->status_id == 1)
                list-group-item-secondary
                @elseif($event->status_id == 2)
                list-group-item-danger
                @elseif($event->status_id == 3)
                list-group-item-info
                @elseif($event->status_id == 4)
                list-group-item-success
                @elseif($event->status_id == 5)
                list-group-item-info
                @elseif($event->status_id == 6)
                list-group-item-dark
                @endif
                "
                >
                    {{ $event->status }}
                </li>
                <li class="list-group-item">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                Registration
                            </div>
                            <div class="col">
                            @if(!empty($event->start_registration) and !empty($event->end_registration))
                            {!! $event->start_registration.' to '.$event->end_registration !!}
                            @else
                            -
                            @endif
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                Activity
                            </div>
                            <div class="col">
                            {!! $event->start_event.' to '.$event->end_event !!}
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('site.event.show', ['type'=>base64_encode($event->event_id),'encode'=>base64_encode($event->id)]) }}" class="btn btn-outline-primary btn-block">Show</a>
                </li>
            </ul>
        </div>
    </div>
</div>