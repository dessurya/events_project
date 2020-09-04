<div class="trending-area fix">
	<div class="container">
		<div class="trending-main" style="border : none;">
			<div class="row">
				<div class="col-lg-12">
					<div class="trending-tittle" style="padding-bottom: 0px;">
						<strong>Info Terkini</strong>
						<div class="trending-animated">
							<ul id="js-news" class="js-hidden">
								@if(count($texts) > 0)
								@foreach($texts as $row)
								<li class="news-item">{{ $row->text }}</li>
								@endforeach
								@else
								<li class="news-item">Halooo Player, are you ready to wins your price and get your dream</li>
								@endif
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
