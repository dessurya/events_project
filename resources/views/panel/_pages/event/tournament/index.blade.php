@extends('panel._layouts.base')

@section('title')
{{ $config['page']['title'] }}
@endsection

@push('link')
@include('panel._componen.summernote_link')
@include('panel._componen.select2_link')
@endpush

@push('script')
@include('panel._componen.summernote_script', ['config' => $config['dtable']])
@include('panel._componen.select2_script', ['config' => $config['dtable']])
@include('panel._componen.dtables_script', ['config' => $config['dtable']])
@include('panel._componen.read_excel_file')
<script type="text/javascript">
	function toggleDateConfig() {
		var newVal = $('[name=flag_gs_n_date]').val();
		if (newVal == null || newVal == 1) { $('#gsndateConfig').show(); }
		else if (newVal == 2) { $('#gsndateConfig').hide(); }
	}

	function toggleFlagRegistration() {
		var newVal = $('[name=flag_registration]').val();
		if (newVal == null || newVal == 1) { 
			$('.target_flag_registration_col').removeClass('col-sm-12').removeClass('col-sm-4').addClass('col-sm-4'); 
			$('.target_flag_registration_hide').show();
		}
		else if (newVal == 2) { 
			$('.target_flag_registration_col').removeClass('col-sm-12').removeClass('col-sm-4').addClass('col-sm-12'); 
			$('.target_flag_registration_hide').hide();
		 }
	}

	function validateForm(data) {
		if (data.flag_gs_n_date == 2) { return false; }
		var error = [];
		var start_registration = new Date(data.start_registration);
		var end_registration = new Date(data.end_registration);
		var start_activity = new Date(data.start_activity);
		var end_activity = new Date(data.end_activity);
		var today = new Date();
		if (data.flag_registration == null) { error.push('field registration required!'); }
		// if (data.id == "" && today > start_activity) { error.push('start_registration must greater than today'); }
		if (data.flag_registration == 1 && start_registration > end_registration) { error.push('end_registration must greater than start_registration'); }
		// if (data.flag_registration == 1 && end_registration > start_activity) { error.push('start_activity must greater than end_registration'); }
		if (start_activity > end_activity) { error.push('end_activity must greater than start_activity'); }
		if(error.length > 0){
			$.each(error, function(index, val){ pnotify({"title":"info","type":"dangger","text":val}); });
			return true;
		}
		return false;
	}

	function checkPrepareId(target) {
		var tId = $(target).data('id');
		if (tId == "" || tId == null) {
			pnotify({"title":"info","type":"dangger","text":"Warning! not selected event!"});
			return false;
		}
		return true;
	}

	function preparePostData(target, input = null) {
		event.preventDefault();
		var tId = $(target).data('id');
		if (checkPrepareId(target) == false) { return false; }
		postData({"id":tId, "input":input}, $(target).attr('href'));
	}

	function prepareGenerateRank(target,refresh) {
		event.preventDefault();
		var tId = $(target).data('id');
		if (checkPrepareId(target) == false) { return false; }
		pnotifyConfirm({
            "title" : "Warning",
            "type" : "info",
            "text" : "Are You Sure Regenerate Ranks?",
            "formData" : false,
            "data" : {'id':tId,'target':refresh},
            "url" : $(target).attr('href')
        });
	}

	function prepareAddPoint(target,refresh) {
		event.preventDefault();
		if ($(target).hasClass('process')) { return false; }
		$(target).toggleClass('process');
		var tId = $(target).data('id');
		if (checkPrepareId(target) == false) { return false; }
		var points = [];
		$.each($('.leaderboard.add-point'), function () {
			if ($(this).val() != 0 && $(this).val() != '' && $(this).val() != undefined) {
				var point = {};
				point['id'] = $(this).data('id');
				point['point'] = $(this).val();
				points.push(point);
			}
		});
		if(points.length == 0){
			$(target).toggleClass('process');
			pnotify({"title":"info","type":"info","text":"Not Add Points"});
			return false;
		}
		$('.leaderboard.add-point').val(null);
		pnotifyConfirm({
            "title" : "Warning",
            "type" : "info",
            "text" : "Are You Sure Add All Points?",
            "formData" : false,
            "data" : {'event_id':tId,'points':points,'target':refresh},
            "url" : $(target).attr('href')
        });
		$(target).toggleClass('process');
	}

	function buildInLeaderboard(config) {
		var result = '';
        if (config.data.length == 0) {
            result += '<tr><td colspan="7" class="text-center">Not data found!</td></tr>';
        }else{
        	var loop = 0;
            $.each(config.data, function(index, val){
            	loop++;
                result += '<tr id='+val.id+'>';
                result += '<td>'+loop+'</td>';
                result += '<td>'+val.participants_website+'</td>';
                result += '<td>'+val.participants_username+'</td>';
                result += '<td>'+val.participants_name+'</td>';
                result += '<td>'+val.participants_point_board+'</td>';
                result += '<td>'+val.participants_rank_board+'</td>';
                result += '<td><input data-id="'+val.id+'" class="leaderboard add-point form-control" type="number" placeholder="add point" ></td>';
                result += '</tr>';
            });
        }
        $(config.target+' table#render tbody').html(result);
        $(config.target+' .card-header .card-title strong').html(config.event.title);
		$(config.target+' .pagination .page-item a.page-link').data('id',config.event.id);
		$(config.target+' #importWrapper button').removeAttr('disabled');
		$(config.target+' #importWrapper #importExcelFile').data('id',config.event.id);
		prepareFormAddParticipants(config.event.id, config.website);
	}

	function prepareFormAddParticipants(eventid, website) {
		$('#leaderboardAddPerticipants .input').val(null).removeAttr('disabled').attr('required', 'true');
		$('#leaderboardAddPerticipants [name=id]').val(eventid);
		$('#leaderboardAddPerticipants button').removeAttr('disabled');
		$('#leaderboardAddPerticipants [name=website]').html(null);
		$.each(website,function(key,val){ $('#leaderboardAddPerticipants [name=website]').append("<option value='"+val+"'>"+val+"</option>") });
	}

	function clickTarget(target) {
		$(target).focus().trigger('click');
	}

	function prepareFilterList(target) {
		var input = {};
		$.each($("form#leaderboardAddPerticipants").find('.input'), function() {
			if ($(this).hasClass('select')) { input[$(this).attr('name')] = $(this).find('option:selected').val() }
			else{ input[$(this).attr('name')] = $(this).val() }
		});
		preparePostData(target,input);
	}

	$(document).on('submit', 'form#leaderboardAddPerticipants', function(){
		var input = {};
		input['form_id'] = $(this).attr('id');
		$.each($(this).find('.input'), function() {
			if ($(this).hasClass('select')) { input[$(this).attr('name')] = $(this).find('option:selected').val() }
			else{ input[$(this).attr('name')] = $(this).val() }
		});
		pnotifyConfirm({
			"title": "Warning",
			"type": "info",
			"text": "Are You Sure Add New Participants?",
			"formData": false,
			"data": input,
			"url": $(this).attr('action')
		});
		return false;
	});

	$(document).on('change', '#importExcelFile', function (evt) {
		if (checkPrepareId('#importExcelFile') == false) { 
			$(this).val(null); 
			return false; 
		}
		var readFile;
		if(evt.target.files[0] != undefined) {
			readExcelFile(evt.target.files[0],"{{ route('panel.event.tournament.importaddparticipants') }}",$(this).data('id'));
			$(this).val(null);
		}
	});
</script>
@endpush

@push('script.documentreadyfunction')
@include('panel._componen.dtables_script_documentreadyfunction')
@endpush

@push('script.responsePostData')
@include('panel._componen.dtables_script_responsePostData')
@include('panel._componen.summernote_script_responsePostData')
@include('panel._componen.select2_script_responsePostData')
if(data.buildInLeaderboard == true){ buildInLeaderboard(data.buildInLeaderboard_config); }
if(data.preparePostData == true){ preparePostData(data.preparePostData_target); }
@endpush

@push('script.postDataBeforeSend')
if(url == "{!! $config['route_validate'] !!}"){
	var checkValidate = validateForm(data);
	if(checkValidate == true){
		return false;
	}
}
@endpush


@push('content')
@include('panel._componen.tabs', ['config' => $config['page']['tabs']])
@endpush