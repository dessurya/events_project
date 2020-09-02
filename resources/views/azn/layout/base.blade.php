<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{ App\Http\Controllers\Azn\HomeController::interfaceGetTitle() }} - @yield('title')</title>
		<link rel="icon" type="image/png" href="{{ App\Http\Controllers\Site\HomeController::interfaceGetIcon() }}" />

		<link rel="stylesheet" href="{{ asset('vendor_azn/assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor_azn/assets/css/owl.carousel.min.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor_azn/assets/css/ticker-style.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor_azn/assets/css/flaticon.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor_azn/assets/css/slicknav.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor_azn/assets/css/animate.min.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor_azn/assets/css/magnific-popup.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor_azn/assets/css/fontawesome-all.min.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor_azn/assets/css/themify-icons.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor_azn/assets/css/slick.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor_azn/assets/css/nice-select.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor_azn/assets/css/style.css') }}">
		@stack('link')
	</head>
	<body>
		
		<header>@include('azn.layout.header')</header>
		{{ App\Http\Controllers\Azn\HomeController::runningTextGet() }}

		@stack('content')

		<footer>
			<div class="footer-area footer-padding fix">
				<div class="container">
					{{ App\Http\Controllers\Azn\HomeController::interfaceGetFooter() }}
				</div>
			</div>
		</footer>
		<!-- All JS Custom Plugins Link Here here -->
        <script src="{{ asset('vendor_azn/assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
		<!-- Jquery, Popper, Bootstrap -->
		<script src="{{ asset('vendor_azn/assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
        <script src="{{ asset('vendor_azn/assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('vendor_azn/assets/js/bootstrap.min.js') }}"></script>
	    <!-- Jquery Mobile Menu -->
        <script src="{{ asset('vendor_azn/assets/js/jquery.slicknav.min.js') }}"></script>

		<!-- Jquery Slick , Owl-Carousel Plugins -->
        <script src="{{ asset('vendor_azn/assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('vendor_azn/assets/js/slick.min.js') }}"></script>
        <!-- Date Picker -->
        <script src="{{ asset('vendor_azn/assets/js/gijgo.min.js') }}"></script>
		<!-- One Page, Animated-HeadLin -->
        <script src="{{ asset('vendor_azn/assets/js/wow.min.js') }}"></script>
		<script src="{{ asset('vendor_azn/assets/js/animated.headline.js') }}"></script>
        <script src="{{ asset('vendor_azn/assets/js/jquery.magnific-popup.js') }}"></script>

        <!-- Breaking New Pluging -->
        <script src="{{ asset('vendor_azn/assets/js/jquery.ticker.js') }}"></script>
        <script src="{{ asset('vendor_azn/assets/js/site.js') }}"></script>

		<!-- Scrollup, nice-select, sticky -->
        <script src="{{ asset('vendor_azn/assets/js/jquery.scrollUp.min.js') }}"></script>
        <script src="{{ asset('vendor_azn/assets/js/jquery.nice-select.min.js') }}"></script>
		<script src="{{ asset('vendor_azn/assets/js/jquery.sticky.js') }}"></script>
        
        <!-- contact js -->
        <script src="{{ asset('vendor_azn/assets/js/contact.js') }}"></script>
        <script src="{{ asset('vendor_azn/assets/js/jquery.form.js') }}"></script>
        <script src="{{ asset('vendor_azn/assets/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('vendor_azn/assets/js/mail-script.js') }}"></script>
        <script src="{{ asset('vendor_azn/assets/js/jquery.ajaxchimp.min.js') }}"></script>
        
		<!-- Jquery Plugins, main Jquery -->	
        <script src="{{ asset('vendor_azn/assets/js/plugins.js') }}"></script>
        <script src="{{ asset('vendor_azn/assets/js/main.js') }}"></script>

        @stack('script')
	</body>
</html>