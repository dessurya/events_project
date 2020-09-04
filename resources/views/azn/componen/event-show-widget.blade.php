<aside class="single_sidebar_widget evnt_recent">
	<h3 class="widget_title">{{ Str::title($widget_title) }}</h3>
	@foreach($param as $row)
	<div class="row mb-20">
		<div class="col-4">
			<div class="img d-block w-100" title="{{ Str::title($row->title) }}"
			@if(!empty($row->picture))
	        style="background-image : url({{ $row->picture }})"
	        @else
	        style="background-image : url({{ asset('images/manandapple.jpg') }})"
	        @endif
			></div>
		</div>
		<div class="col-8">
			<h6><a class="hover" href="{{ route('azn.event.show', ['type'=>base64_encode($row->event_id),'encode'=>base64_encode($row->id)]) }}">{{ Str::title($row->title) }}</a></h6>
			@if($date == 'start')
			<small>{{ (new Carbon\Carbon($row->start_event))->format('F, d Y') }}</small>
			@elseif($date == 'end')
			<small>{{ (new Carbon\Carbon($row->end_event))->format('F, d Y') }}</small>
			@endif
			@if(!empty($row->description))
			<p class="text-justify">{!! Str::words(strip_tags($row->description), 10, '...') !!}</p>
			@endif
		</div>
	</div>
	@endforeach
</aside>