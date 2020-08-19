<ul class="list-group list-group-flush">
    <a href="#" class="list-group-item list-group-item-action active">On Going Event</a>
    @foreach($events['ongoing'] as $event)
    <a href="{{ route('site.event.show', ['type'=>base64_encode($event->event_id),'encode'=>base64_encode($event->id)]) }}" class="list-group-item list-group-item-action list-group-item-light" title="{{ Str::title($event->title).' - '.$event->event }}">
        {{ Str::words(Str::title($event->title),3,'...') }}
    </a>
    @endforeach
    <a href="{{ route('site.event.ongoing') }}" class="list-group-item list-group-item-action list-group-item-dark">View More On Going Event</a>
    <a href="#" class="list-group-item list-group-item-action active">Upcomming Event</a>
    @foreach($events['upcomming'] as $event)
    <a href="{{ route('site.event.show', ['type'=>base64_encode($event->event_id),'encode'=>base64_encode($event->id)]) }}" class="list-group-item list-group-item-action list-group-item-light" title="{{ Str::title($event->title).' - '.$event->event }}">
    {{ Str::words(Str::title($event->title),3,'...') }} <span class="badge {{ $event->status_id == 2 ? 'badge-danger' : 'badge-info'}}">{{ $event->status }}</span>
    </a>
    @endforeach
    <a href="{{ route('site.event.upcomming') }}" class="list-group-item list-group-item-action list-group-item-dark">View More Upcomming Event</a>
    <a href="#" class="list-group-item list-group-item-action active">Past Event</a>
    @foreach($events['past'] as $event)
    <a href="{{ route('site.event.show', ['type'=>base64_encode($event->event_id),'encode'=>base64_encode($event->id)]) }}" class="list-group-item list-group-item-action list-group-item-light" title="{{ Str::title($event->title).' - '.$event->event }}">
        {{ Str::words(Str::title($event->title),3,'...') }}
    </a>
    @endforeach
    <a href="{{ route('site.event.past') }}" class="list-group-item list-group-item-action list-group-item-dark">View More Past Event</a>
</ul>