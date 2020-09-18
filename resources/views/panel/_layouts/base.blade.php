<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Panel Page - @yield('title')</title>
		@include('panel._layouts.link')
		@stack('link')
	</head>
	<body class="hold-transition sidebar-mini">
		<div class="wrapper">
			@include('panel._layouts.nav')
			@include('panel._layouts.aside')
			<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1>@yield('title')</h1>
						</div>
					</div>
				</div>
			</section>
				@stack('content')
			</div>
			@include('panel._layouts.footer')
			<aside class="control-sidebar control-sidebar-dark"></aside>
		</div>
		<div id="loading-page">
            <div class="dis-table">
                <div class="row">
                    <div class="cel">
                        <img src="{{ asset('images/loading_1.gif') }}">
                    </div>
                </div>
            </div>
        </div>
		@include('panel._layouts.script')
		@stack('script')
	</body>
</html>