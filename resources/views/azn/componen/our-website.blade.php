<div class="weekly2-news-area  weekly2-pading">
	<div class="container">
		<div class="weekly2-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<div class="section-tittle mb-50">
						<h3>
							Our Website
						</h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div id="webiste-slick" class="dot-style d-flex dot-style">
						@foreach($MasterWebsite as $key => $row)
						<div class="weekly2-single">
							<a href="{{ empty($row->url) ? '#' : $row->url }}">
								<div class="weekly2-img">
									<div class="img d-block w-100" title="{{ $row->name }}"
									@if(!empty($row->picture))
									style="background-image : url({{ $row->picture }})"
									@else
									style="background-image : url({{ asset('images/manandapple.jpg') }})"
									@endif
									></div>
								</div>
								<div class="weekly2-caption">
									<span class="color1">{{ $row->name }}</span>
								</div>
							</a>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>