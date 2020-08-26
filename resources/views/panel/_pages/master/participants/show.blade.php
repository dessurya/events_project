<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">{{ Str::title($config['Participants']->name).' ( '.$config['Participants']->username.' ) ' }}</h3>
	</div>
	<div class="card-body">
		
		<ul class="nav nav-tabs" id="custom-tabs-participantsshow-tab" role="tablist" data-pagetourne="1" data-pagecoupon="1">
			<li class="nav-item">
				<a 
                    class="nav-link active" 
                    id="custom-tabs-profile-tab" 
                    data-toggle="tab" 
                    href="#custom-tabs-profile">Profile</a>
			</li>
			<li class="nav-item">
				<a 
                    class="nav-link" 
                    id="custom-tabs-tournament-tab" 
                    data-toggle="tab" 
                    href="#custom-tabs-tournament">Tournament TO</a>
			</li>
			<li class="nav-item">
				<a 
                    class="nav-link" 
                    id="custom-tabs-coupon-tab" 
                    data-toggle="tab" 
                    href="#custom-tabs-coupon">Coupon</a>
			</li>
		</ul>
		<div class="tab-content" id="custom-tabs-participantsshow-tabContent">
			<div 
                class="tab-pane fade active show" 
                id="custom-tabs-profile">
                <div class="row">
		            <div class="col-12">
						<div class="card">
							<div class="card-header">
							    <h3 class="card-title">Participant Profile</h3>
							</div>
							<div class="card-body p-0">
				                <div class="row" style="padding: 10px 15px;">
						            <div class="col-sm-6">
										<div class="form-group">
											<label>Username</label>
											<input readonly type="text" class="form-control" value="{{ $config['Participants']->username }}">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Name</label>
											<input readonly type="text" class="form-control" value="{{ Str::title($config['Participants']->name) }}">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>No Rekening</label>
											<input readonly type="text" class="form-control" value="{{ $config['Participants']->no_rek }}">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Atas Nama Rekening</label>
											<input readonly type="text" class="form-control" value="{{ Str::title($config['Participants']->nama_rek) }}">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>No Hp</label>
											<input readonly type="text" class="form-control" value="{{ $config['Participants']->no_hp }}">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>IP</label>
											<input readonly type="text" class="form-control" value="{{ Str::title($config['Participants']->ip_participants) }}">
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>Alamat</label>
											<textarea readonly type="text" class="form-control">{{ Str::title($config['Participants']->alamat) }}</textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
            <div 
                class="tab-pane fade" 
                id="custom-tabs-tournament">
                <div class="row">
		            <div class="col-sm-12">
						<div class="card">
						  <div class="card-header">
						    <h3 class="card-title">
						    	Register On
						    	<button class="btn btn-info" title="Load More Data" onclick="getAgainRegisterTourne('{!! $config['Participants']->id !!}')">
		                                <i class="fas fa-plus"></i>
	                            </button>
						    </h3>
						  </div>
						  <div class="card-body p-0">
						    <table class="table table-striped">
						      <thead>
						        <tr>
						          <th>Status Event</th>
						          <th>Event</th>
						          <th>Status Participants</th>
						          <th>Point</th>
						          <th>Rank</th>
						        </tr>
						      </thead>
						      <tbody>
						      	@if(count($config['ViewEventTournamentParticipants']) > 0)
						      	@foreach($config['ViewEventTournamentParticipants'] as $row)
						      	<tr>
						      		<td>{{ $row->event_status }}</td>
						      		<td>{{ $row->event_tittle }}</td>
						      		<td>{{ $row->participants_status }}</td>
						      		<td>{{ $row->participants_point_board }}</td>
						      		<td>{{ $row->participants_rank_board }}</td>
						      	</tr>
						      	@endforeach
						      	@else
						      	<tr><td colspan="6">Record Not Found!</td></tr>
						      	@endif
						      </tbody>
						    </table>
						  </div>
						</div>
		            </div>
				</div>
            </div>
            <div 
                class="tab-pane fade" 
                id="custom-tabs-coupon">
                <div class="row">
		            <div class="col-sm-12">
						<div class="card">
						  <div class="card-header">
						    <h3 class="card-title">
						    	Coupon
						    	<button class="btn btn-info" title="Load More Data" onclick="getAgainCoupon('{!! $config['Participants']->id !!}')">
		                                <i class="fas fa-plus"></i>
	                            </button>
						    </h3>
						  </div>
						  <div class="card-body p-0">
						    <table class="table table-striped">
						      <thead>
						        <tr>
						          <th>Code</th>
						          <th>Status</th>
						          <th>Confirm At</th>
						          <th>Event Title</th>
						          <th>Event Status</th>
						          <th>Created At</th>
						        </tr>
						      </thead>
						      <tbody>
						      	@if(count($config['ViewParticipantsCoupon']) > 0)
						      	@foreach($config['ViewParticipantsCoupon'] as $row)
						      	<tr id="{{ $row->id }}">
						      		<td>{{ $row->coupon_code }}</td>
						      		<td>{{ $row->coupon_status }}</td>
						      		<td>{{ $row->confirm_at }}</td>
						      		<td>{{ $row->event_coupon_title }}</td>
						      		<td>{{ $row->event_coupon_status }}</td>
						      		<td>{{ $row->created_at }}</td>
						      	</tr>
						      	@endforeach
						      	@else
						      	<tr><td colspan="7">Record Not Found!</td></tr>
						      	@endif
						      </tbody>
						    </table>
						  </div>
						</div>
		            </div>
				</div>
            </div>
		</div>
		
	</div>
</div>
