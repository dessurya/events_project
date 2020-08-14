@extends('panel._layouts.base')

@section('title')
 Your Profile
@endsection

@push('content')
    <div class="col-12">

		<div class="card card-primary">
			<div class="card-header">
				<h3 class="card-title">Your Profile</h3>
			</div>
			<form id="your_profile" class="postData" method="post" action="{{ route('panel.self-data-store') }}">
				@if(Session::has('status'))
				<div class="alert alert-info" role="alert">
					{{ Session::get('status') }}
				</div>
				@endif
				{{ csrf_field() }}
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Username</label>
								<input required value="{{ $data->username }}" name="username" type="text" class="form-control input">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Name</label>
								<input required value="{{ $data->name }}" name="name" type="text" class="form-control input">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Email</label>
								<input required value="{{ $data->email }}" name="email" type="email" class="form-control input">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Phone</label>
								<input value="{{ $data->phone }}" name="phone" type="text" class="form-control input">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Old Password</label>
								<input required  name="old_password" type="password" class="form-control input">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>New Password</label>
								<input  name="new_password" type="password" class="form-control input">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Re Password</label>
								<input  name="re_password" type="password" class="form-control input">
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
@endpush