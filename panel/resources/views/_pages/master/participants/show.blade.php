<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">{{ Str::title($config['Participants']->name) }}</h3>
	</div>
	<div class="card-body">
		<div class="row">
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
					<label>IP</label>
					<textarea readonly type="text" class="form-control">{{ Str::title($config['Participants']->alamat) }}</textarea>
				</div>
			</div>
		</div>

		<div class="row">
            <div class="col-sm-12">
				<div class="card">
				  <div class="card-header">
				    <h3 class="card-title">Register On</h3>
				  </div>
				  <div class="card-body p-0">
				    <table class="table table-striped">
				      <thead>
				        <tr>
				          <th>Status Event</th>
				          <th>Event</th>
				          <th>Website</th>
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
				      		<td>{{ $row->event_website }}</td>
				      		<td>{{ $row->participants_status }}</td>
				      		<td>{{ $row->participants_point_board }}</td>
				      		<td>{{ $row->participants_rank_board }}</td>
				      	</tr>
				      	@endforeach
				      	@else
				      	<tr><td colspan="5">Record Not Found!</td></tr>
				      	@endif
				      </tbody>
				    </table>
				  </div>
				</div>
            </div>
		</div>
	</div>
</div>
