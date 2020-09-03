<div class="col-lg-4">
    <article class="blog_item">
        <div class="blog_item_img">
            <div class="img d-block w-100" title="{{ $event->title }}"
            @if(!empty($event->picture))
            style="background-image : url({{ $event->picture }})"
            @else
            style="background-image : url({{ asset('images/manandapple.jpg') }})"
            @endif
            ></div>
            <a 
                href="{{ route('azn.event.show', ['type'=>base64_encode($event->event_id),'encode'=>base64_encode($event->id)]) }}" 
                class="blog_item_date color-{{ $event->status_id }}"
            >
                <h3>{{ (new Carbon\Carbon($event->start_event))->format('M, Y') }}</h3>
                <p>{{ (new Carbon\Carbon($event->start_event))->format('D, d') }}</p>
            </a>
        </div>
        <div class="blog_details">
            <a class="d-inline-block" href="{{ route('azn.event.show', ['type'=>base64_encode($event->event_id),'encode'=>base64_encode($event->id)]) }}">
                <h2>{{ Str::title($event->title) }}</h2>
            </a>
            <p>{!! Str::words(strip_tags($event->description), 20, '...') !!}</p>
            <ul class="blog-info-link">
                <li>{{ $event->event }}</li>
                <li>{{ $event->status }}</li>
            </ul>
        </div>
    </article>
</div>