<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Admin Page</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<link rel="stylesheet" type="text/css" href="{{ asset('vendors/fontawesome-free/css/all.min.css') }}">
		<link rel="stylesheet" href="{{ asset('vendors/icheck-bootstrap/icheck-bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('vendors/adminlte-dist/css/adminlte.min.css') }}">
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<a href="#">Welcome To <b>Panel</b> Area</a>
			</div>

			<div class="card">
				<div class="card-body login-card-body">
					<p class="login-box-msg">Sign in to start your session</p>
					@if(Session::has('status'))
					<div class="alert alert-danger" role="alert">
						{{ Session::get('status') }}
					</div>
					@endif
					<form action="{{ route('panel.signin') }}" method="post">
						{{ csrf_field() }}
						<div class="input-group mb-3">
							<input required name="username" type="text" class="form-control" placeholder="Username">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-user"></span>
								</div>
							</div>
						</div>
						<div class="input-group mb-3">
							<input required name="password" type="password" class="form-control" placeholder="Password">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-lock"></span>
								</div>
							</div>
						</div>
						<div class="input-group mb-3">
							<button class="btn btn-outline-primary btn-block" type="submit">Login</button>							
						</div>
					</form>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="{{ asset('vendors/jquery/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('vendors/adminlte-dist/js/adminlte.min.js') }}"></script>
	</body>
</html>