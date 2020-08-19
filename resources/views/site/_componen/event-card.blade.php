<div class="col-6">
    <div class="card mb-3">
        
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
            <p class="card-text text-center"><small class="text-muted">
                @if(!empty($event->start_registration) and !empty($event->end_registration)){{ $event->start_registration.' - '.$event->end_registration }} | @endif<span class="badge {{ $event->status_id == 2 ? 'badge-danger' : 'badge-info'}}">{{ $event->status }}</span> | {{ $event->start_event.' - '.$event->end_event }}
            </small></p>
            <a href="{{ route('site.event.show', ['type'=>base64_encode($event->event_id),'encode'=>base64_encode($event->id)]) }}" class="btn btn-outline-primary btn-block">Show Event</a>
        </div>
    </div>
</div>