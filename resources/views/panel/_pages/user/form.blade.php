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
						<label>Username</label>
						<input readonly name="username" type="text" class="form-control input">
					</div>
				</div>
                <div class="col-sm-6">
					<div class="form-group">
						<label>Name</label>
						<input readonly name="name" type="text" class="form-control input">
					</div>
				</div>
                <div class="col-sm-6">
					<div class="form-group">
						<label>Email</label>
						<input readonly name="email" type="email" class="form-control input">
					</div>
				</div>
                <div class="col-sm-6">
					<div class="form-group">
						<label>Phone</label>
						<input readonly name="phone" type="text" class="form-control input">
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer">
			<button disabled type="submit" class="btn btn-primary">Submit</button>
		</div>
	</form>
</div>