<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ App\Http\Controllers\Site\HomeController::interfaceGetDescription() }}">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{{ App\Http\Controllers\Site\HomeController::interfaceGetTitle() }} - @yield('title')</title>
        <link rel="icon" type="image/png" href="{{ App\Http\Controllers\Site\HomeController::interfaceGetIcon() }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('vendors/fontawesome-free/css/all.min.css') }}">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<link rel="stylesheet" href="{{ asset('vendors/pnotify/pnotify.custom.min.css') }}">
		<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@1,600&family=Roboto+Slab:wght@300&display=swap" rel="stylesheet">
		<style type="text/css">
            body{
				font-family: 'Roboto Slab', serif;
                background: #f2f2f2;
            }
			nav, h1, h2, h3, h4, h5, h6{
				/* font-family: 'Public Sans', sans-serif; */
				font-family: 'Roboto Slab', serif;
			}
			marquee{
				margin-bottom : -6px;
			}
			#footer{
				padding: 16px 0;
			}
			#footer p{
				margin: 0;
			}
			.hide{
				display :none;
			}
			/* loading page */
		        #loading-page{
		            position: fixed;
		            top: 0;
		            z-index: 99999;
		            width: 100vw;
		            height: 100vh;
		            background-color: rgba(112,112,112,.4);
		            transition: all 1.51s;
		        }
		        #loading-page .dis-table .row .cel{
		            text-align: center;
		            width: 100%;
		            height: 100vh;
		        }
		    /* loading page */
		</style>
		@stack('link')
	</head>
	<body>
        @include('site._layouts.navbar')
        {{ App\Http\Controllers\Site\HomeController::runningTextGet() }}
        @stack('content')
		<div id="footer" class="bg-dark text-white">
			<div class="container">
			{!! App\Http\Controllers\Site\HomeController::interfaceGetFooter() !!}
			</div>
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
		<script type="text/javascript" src="{{ asset('vendors/jquery/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('vendors/pnotify/pnotify.custom.min.js') }}"></script>
		<script type="text/javascript">
			$( document ).ready(function() {
                $('#loading-page').hide();
                $.each($('.carousel .carousel-inner'), function(){
                    $(this).find('.carousel-item').first().addClass('active');
                });
                $('.carousel').carousel({
                    interval: 4000
                });
				@stack('script.documentreadyfunction')
			});

			$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
			function pnotify(data) {
				new PNotify({
					title: data.title,
					text: data.text,
					type: data.type,
					delay: 3000
				});
			}
			function pnotify_arr(data) {
				$.each(data, function (idx, val) {
					pnotify({"title":"info","type":val.type,"text":val.text});
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

			function toogleClass(param, target) {
				if(target== 'self'){
					console.log(this);
					// $(target).toggleClass(param);
				}else{
					$(target).toggleClass(param);
				}
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

			function responsePostData(data) {
				@stack('script.responsePostData')
				if (data.pnotify === true) { pnotify({"title":"info","type":data.pnotify_type,"text":data.pnotify_text}); }
				if (data.pnotify_arr === true) { pnotify_arr(data.pnotify_arr_data); }
				if (data.render == true) { render(data.render_config); }
				if (data.playAudioApplauses == true) { playAudioApplauses(); }
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