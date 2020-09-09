<div class="trending-area fix">
	<div class="container">
		<div class="trending-main" style="border : none;">
			<div class="row">
				<div class="col-lg-12">
					<div class="trending-tittle" style="padding-bottom: 0px;">
						<strong>Info Terkini</strong>
						<div class="trending-animated">
							@if(count($texts) > 0)
							<ul id="js-news" class="js-hidden">
								@foreach($texts as $idx => $row)
								<li class="news-item">{{ $row->text }}</li>
								@endforeach
							</ul>
							<marquee>
								@foreach($texts as $idx => $row)
								@if($idx > 0) <label style="width:75vw;"></label> @endif
								<label>{{ $row->text }}</label>
								@endforeach
							</marquee>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
