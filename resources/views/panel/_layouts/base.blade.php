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
		<script type="text/javascript" src="{{ asset('vendors/jquery/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('vendors/popper.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<?php
		// <script type="text/javascript" src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
		?>
		<script type="text/javascript" src="{{ asset('vendors/adminlte-dist/js/adminlte.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('vendors/pnotify/pnotify.custom.min.js') }}"></script>
		<script type="text/javascript">
			$( document ).ready(function() {
				cekNewRegister('run');
				checkEventAddParticipants();
				$('#loading-page').hide();
				@stack('script.documentreadyfunction')
			});

			function cekNewRegister(param) {
				var url = '{!! route("panel.newRegisterEventCheck") !!}';
				postData({'param':param},url);
				window.setTimeout(function() { 
					cekNewRegister('false');
				// }, 5000); // 5 second waiting end run again
				}, 10000); // 10 second waiting end run again
				// // }, 30000); // 30 second waiting end run again
				// }, 50000); // 50 second waiting end run again
				// // }, 600000); // 1 menit waiting end run again
				// // }, 1200000); // 2 menit waiting end run again
				// // }, 300000); // 5 menit waiting end run again
			}

			function playAudioApplauses() { 
				var audio = new Audio('{!! asset('asset/applauses.mp3') !!}');
				audio.play();
				console.log('audio is command!');
			} 


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
					$(ui.container).find(".true").hide();
					if (data.formData == true) {
						postFormData(data.data,data.url);
					}else{
						postData(data.data,data.url);
					}
				});
			}
			function PNotifynotice_arr(data) {
				$.each(data, function (idx, val) {
					PNotifynotice(val);
				});
			}
			function PNotifynotice(data) {
				new PNotify({
					title: data.title,
					text: data.text,
					type: data.type,
					// hide: false,
					// sticker: false,
					confirm: {
						confirm: true,
						buttons:[
							{ text: 'Show', addClass: 'true btn-primary', removeClass: 'btn-default'},
							{ text: 'No', addClass: 'hide'}
						]
					}
				}).get().on('pnotify.confirm', function(ui){
					$(".true", ui.container).hide();
					window.location.replace(data.url);
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
				if (data.PNotifynotice_arr == true) { PNotifynotice_arr(data.PNotifynotice_arr_data); }
				if (data.prepareEventAddParticipants == true) { prepareEventAddParticipants(data.prepareEventAddParticipantsConfig); }
			}

			function prepareEventAddParticipants(data) {
				localStorage.setItem('eventAddParticipants', JSON.stringify(data));
				checkEventAddParticipants();
			}
			function checkEventAddParticipants() {
				var getItem = localStorage.getItem('eventAddParticipants');
				if (getItem != 'null' && getItem != null && getItem != '' && getItem != undefined && getItem != "undefined" && getItem.length != 0) {
					renderActionEventAddParticipants(JSON.parse(getItem));
				}
			}
			function renderActionEventAddParticipants(getItem) {
				PNotifynotice({'title':'Warning! Event Add Participants','type':'error','url':'{!! route('panel.master.participants.list') !!}','text':getItem.msg+'. For continue please click SHOW button'});
				var renderContent = '<div class="container"><div class="row"><div class="col-12"><div class="card"><div class="card-body">';
				renderContent += '<h5 class="card-title">'+getItem.msg+'</h5>';
				renderContent += '<br><br>';
				renderContent += '<div class="btn-group btn-block" role="group" aria-label="Basic example">';
				renderContent += '<a href="{!! route('panel.master.participants.list') !!}" class="btn btn-danger btn-xs">Show</a>';
				renderContent += '<button type="button" class="btn btn-info btn-xs" onclick="actionInsertEventAddParticipants()">Add</button>';
				renderContent += '<button type="button" class="btn btn-default btn-xs" onclick="actionEndEventAddParticipants()">End</button>';
				renderContent += '</div>';
				renderContent += '</div></div></div></div></div>';
				render({'target':'#render_some_action','content':btoa(renderContent)});
			}
			function actionInsertEventAddParticipants() {
				if(window.location.href != '{!! route('panel.master.participants.list') !!}'){
					pnotify({"title":"Warning","type":'error',"text":"Sorry, this not Participants List!"});
				}
				id = getSelectedRowId({ "target": "table#d_tables_participants tr.selected", "multiple": true });
				if (id === false) { return false; }
				var getItem = localStorage.getItem('eventAddParticipants');
				getItem = JSON.parse(getItem);
				postData({'participants':id}, getItem.routeStore);
			}
			function actionEndEventAddParticipants() {
				localStorage.removeItem("eventAddParticipants");
				render({'target':'#render_some_action','content':btoa('<div></div>')});
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