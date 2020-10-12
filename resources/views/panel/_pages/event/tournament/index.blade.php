@extends('panel._layouts.base')

@section('title')
{{ $config['page']['title'] }}
@endsection

@push('link')
@include('panel._componen.summernote_link')
@include('panel._componen.select2_link')
<style>
	.hide{
		display:none;
	}
</style>
@endpush

@push('script')
@include('panel._componen.summernote_script', ['config' => $config['dtable']])
@include('panel._componen.select2_script', ['config' => $config['dtable']])
@include('panel._componen.dtables_script', ['config' => $config['dtable']])
@include('panel._componen.read_excel_file')
<script type="text/javascript">
	var websiteOnEvent = null;
	function toggleTo(target) { $(target).toggle() }
	function removeTo(target) { $(target).remove() }
	function clearTo(target) { $(target).html('') }

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
		websiteOnEvent = website;
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

	function renderFormImport(data, id, page, sheetName) {
		if (sheetName != 'import_participants' || data[0]['USERNAME'] == undefined || data[0]['TURNOVER POINT'] == undefined || data[0]['WEBSITE'] == undefined) {
			pnotify({"title":"error","type":"dangger","text":"Your excel format its wrong"})
			clearTo('#importWrapper #renderPrepareForm')
			return false
		}
		var showBtn = '<ul class="pagination pagination-sm float-right"><li class="page-item"><button onclick="toggleTo(\'#importWrapper #renderPrepareForm #ifp'+page+'\')" class="page-link"><i class="fas fa-folder-open"></i></button></li></ul>'
		var card = '<div id="cardifp'+page+'" class="container mt-3"><div class="card">'
		card += '<div class="card-header"><h3 class="card-title">Import Page '+page+'</h3>'+showBtn+'</div>'
		card += '<div id="ifp'+page+'" data-page="'+page+'" data-id="'+id+'" class="card-body p-2 hide"><div class="container p-2">'
		card += '<div class="row"><div class="col-sm-3"><label>Website</label></div><div class="col-sm-3"><label>Username</label></div><div class="col-sm-3"><label>Turnover Point</label></div><div class="col-sm-3"><label>Tools</label></div></div>'
		data.forEach(function (val, idx) {
			card += '<div id="row'+idx+'" class="row p-1 rowVal">'

			card += '<div class="col-sm-3">'
			card += '<select name="website" class="form-control input">'
			$.each(websiteOnEvent,function(wkey,wval){ 
				card += "<option value='"+wval+"'"
				if (wval == val['WEBSITE']) { card += 'selected' }
				card += ">"+wval+"</option>"
			});
			card += '</select>'
			card += '</div>'

			card += '<div class="col-sm-3">'
			card += '<input name="username" type="text" class="form-control input" value="'+val['USERNAME']+'">'
			card += '</div>'

			card += '<div class="col-sm-3">'
			card += '<input name="point" type="number" class="form-control input" value="'+val['TURNOVER POINT']+'">'
			card += '</div>'

			card += '<div class="col-sm-3">'
			card += '<button onclick="removeTo(\'#importWrapper #renderPrepareForm #ifp'+page+' #row'+idx+' \')" class="btn btn-danger">Remove</button>'
			card += '<input type="hidden" name="idx" class="input" value="'+idx+'">'
			card += '</div>'

			card += '</div>'
		});
		card += '<div class="row">'
		card += '<div class="col-sm-6"><button onclick="removeTo(\'#importWrapper #renderPrepareForm #cardifp'+page+' \')" class="btn btn-block btn-danger">Remove Import Page '+page+'</button></div>'
		card += '<div class="col-sm-6"><button onclick="sendImportParticipan(\'#importWrapper #renderPrepareForm #ifp'+page+' \')" class="btn btn-block btn-success">Submit</button></div>'
		card += '</div>'

		card += '</div></div>'
		card += '</div></div>'

		$('#importWrapper #renderPrepareForm').append(card)
		return true;
	}

	function sendImportParticipan(target) {
		var input = {};
		input['id'] = $(target).data('id')
		input['import_page'] = $(target).data('page')
		input['data'] = []
		$.each($(target+' .rowVal'), function() {
			var data = []
			$.each($(this).find('.input'), function(){
				if ($(this).hasClass('select')) { data[$(this).attr('name')] = $(this).find('option:selected').val() }
				else{ data[$(this).attr('name')] = $(this).val() }
				if (data['idx'] !== undefined) { input['data'][data['idx']] = data }
			});
		});
		var makeNew = []
		$.each(input['data'], function(key, val) {
			makeNew[key] = {
				'username' : val.username,
				'website' : val.website,
				'point' : val.point,
			}
		});
		input['data'] = makeNew
		pnotifyConfirm({
			"title": "Warning",
			"type": "info",
			"text": "Are You Sure Import Participants?",
			"formData": false,
			"data": input,
			"url": "{{ route('panel.event.tournament.importaddparticipants') }}"
		});
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
		clearTo('#importWrapper #renderPrepareForm')
		if (checkPrepareId('#importExcelFile') == false) { 
			$(this).val(null); 
			return false; 
		}
		var readFile;
		if(evt.target.files[0] != undefined) {
			readExcelFile(evt.target.files[0],$(this).data('id'));
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