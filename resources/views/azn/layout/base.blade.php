<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">

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
		<link rel="stylesheet" href="{{ asset('vendors/pnotify/pnotify.custom.min.css') }}">
		@stack('link')
	</head>
	<body>
		
		<header>@include('azn.layout.header')</header>

		<main>
		{{ App\Http\Controllers\Azn\HomeController::runningTextGet() }}
		@stack('content')
		</main>

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
        <script src="{{ asset('vendor_azn/assets/js/main.js') }}?v=0.0.1"></script>

        <script type="text/javascript" src="{{ asset('vendors/pnotify/pnotify.custom.min.js') }}"></script>
        <script type="text/javascript">
        	$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
			function pnotify(data) {
				new PNotify({
					title: data.title,
					text: data.text,
					type: data.type,
					delay: 3000
				});
			}
			function postData(data,url) {
				$.ajax({
					url: url,
					type: 'post',
					dataType: 'json',
					data: data,
					beforeSend: function() {
						@stack('script.postDataBeforeSend')
						$('#loading-page').show();
					},
					success: function(data) {
						responsePostData(data);
						$('#loading-page').hide();
					}
				});
			}

			function pnotifyConfirm(data) {
				new PNotify({
					after_open: function(ui){
						$(".true", ui.container).focus();
						$('#loading-page').show();
					},
					after_close: function(){
						$('#loading-page').hide();
					},
					title: data.title,
					text: data.text,
					type: data.type,
					delay: 3000,
					confirm: {
						confirm: true,
						buttons:[
						{ text: 'Yes', addClass: 'true btn-primary', removeClass: 'btn-default'},
						{ text: 'No', addClass: 'false'}
						]
					}
				}).get().on('pnotify.confirm', function(ui){
					$(".true", ui.container).hide();
					if (data.formData == true) {
						postFormData(data.data,data.url);
					}else{
						postData(data.data,data.url);
					}
				});
			}

			function responsePostData(data) {
				@stack('script.responsePostData')
				if (data.pnotify == true) { pnotify({"title":"info","type":data.pnotify_type,"text":data.pnotify_text}); }
				if (data.render == true) { render(data.render_config); }
				if (data.prepend == true) { prepend(data.prepend_config); }
				if (data.append == true) { append(data.append_config); }
			}

			function render(data) {
				$(data.target).html(atob(data.content));
			}
			function prepend(data) {
				$(data.target).prepend(atob(data.content));
			}
			function append(data) {
				$(data.target).append(atob(data.content));
			}
        </script>
        @stack('script')
	</body>
</html>