@if(count($texts) > 0)
<div class="trending-area fix">
	<div class="container">
		<div class="trending-main" style="border : none;">
			<div class="row">
				<div class="col-lg-12">
					<div class="trending-tittle" style="padding-bottom: 0px;">
						<strong>Trending now</strong>
						<div class="trending-animated">
							<ul id="js-news" class="js-hidden">
								@foreach($texts as $row)
								<li class="news-item">{{ $row->text }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
