<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">{{ $config['title'] }}</h3>
	</div>
	<form id="{{ $config['id'] }}" class="postData" method="post" action="{{ route($config['action']) }}">
		<input type="hidden" name="id" class="input">
		<div class="card-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label>Title</label>
						<input disabled name="title" type="text" class="form-control input">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Prize</label>
						<input disabled name="prize" type="number" class="form-control input">
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label>Website</label>
						<select disabled name="website" class="form-control input select2bs4" multiple="multiple">
							@foreach($website as $list)
							<option value="{{ $list->id }}">{{ $list->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label>Event Status</label>
						<select disabled name="flag_status" class="form-control input select">
						@foreach($status_event as $row)
						<option value="{{$row->self_id}}">{{$row->value}}</option>
						@endforeach
						</select>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="card card-secondary">
						<div class="card-header">
							<div class="form-group">
								<label>Auto Generate Event Status And Config Date : </label>
								<select onchange="toggleDateConfig()" disabled name="flag_gs_n_date" class="form-control input select">
								@foreach($flag_gs_n_date as $row)
								<option value="{{$row->self_id}}">{{$row->value}}</option>
								@endforeach
								</select>
							</div>
						</div>
						<div id="gsndateConfig" class="card-body">
							<div class="row">
								<div class="col-sm-4 target_flag_registration_col">
									<div class="form-group">
										<label>Registration : </label>
										<select onchange="toggleFlagRegistration()" disabled name="flag_registration" class="form-control input select">
										@foreach($flag_registration as $row)
										<option value="{{$row->self_id}}">{{$row->value}}</option>
										@endforeach
										</select>
									</div>
								</div>
								<div class="col-sm-4 target_flag_registration_hide">
									<div class="form-group">
										<label>Registration Start On : </label>
										<input disabled name="start_registration" type="date" class="form-control input date">
									</div>
								</div>
								<div class="col-sm-4 target_flag_registration_hide">
									<div class="form-group">
										<label>Registration End On : </label>
										<input disabled name="end_registration" type="date" class="form-control input date">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Activity Start On : </label>
										<input disabled name="start_activity" type="date" class="form-control input date">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Activity End On : </label>
										<input disabled name="end_activity" type="date" class="form-control input date">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label>Description</label>
						<textarea required name="description" type="file" class="summernote form-control input"></textarea>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label>Terms and Conditions</label>
						<textarea required name="terms_and_conditions" type="file" class="summernote form-control input"></textarea>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label>Picture</label>
						<input name="picture" type="file" class="form-control input file" accept=".png,.jpg,jpeg,.gif">
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group" style="border: .5px solid gray; border-radius: 6px;">
						<img class="img-fluid picture" src="" style="display: none;">
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button disabled type="submit" class="btn btn-primary">Submit</button>
		</div>
	</form>
</div>