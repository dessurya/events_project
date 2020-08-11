<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Panel Page - @yield('title')</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<link rel="stylesheet" type="text/css" href="{{ asset('vendors/fontawesome-free/css/all.min.css') }}">
		<link rel="stylesheet" href=" {{ asset('vendors/overlayScrollbars/css/OverlayScrollbars.min.css')}} ">
		<link rel="stylesheet" type="text/css" href="{{ asset('vendors/adminlte-dist/css/adminlte.min.css') }}">
		<link rel="stylesheet" href="{{ asset('vendors/pnotify/pnotify.custom.min.css') }}">
		<style type="text/css">
			.hide{
				display :none;
			}

			table.selected-table tbody tr{
				cursor: pointer
			}

			table.selected-table tbody tr.selected{
				background-color: #aab7d1;
			}
			
			table .icon{
				height: 20px;
			}
			.table.table-head-fixed thead tr th{
				min-width : 150px !important;
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
	<body class="hold-transition sidebar-mini">
		<div class="wrapper">
			@include('_layouts.nav')
			@include('_layouts.aside')

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

			@include('_layouts.footer')
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script type="text/javascript" src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('vendors/adminlte-dist/js/adminlte.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('vendors/pnotify/pnotify.custom.min.js') }}"></script>
		<script type="text/javascript">
			$( document ).ready(function() {
				$('#loading-page').hide();
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
				}).get().on('pnotify.confirm', function(){
					if (data.formData == true) {
						postFormData(data.data,data.url);
					}else{
						postData(data.data,data.url);
					}
				});
			}
			function toogleClass(param, target) {
				$(target).toggleClass(param);
			}

			function postData(data,url) {
				$.ajax({
					url: url,
					type: 'post',
					dataType: 'json',
					data: data,
					beforeSend: function() {
						$('#loading-page').show();
						@stack('script.postDataBeforeSend')
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
				if (data.render == true) { render(data); }
			}

			function render(data) {
				$(data.render_config.target).html(atob(data.render_config.content));
			}
		</script>
		@stack('script')
	</body>
</html>