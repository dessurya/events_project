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
		var start_active = new Date(data.start_active);
		var end_active = new Date(data.end_active);
		var today = new Date();
		if (data.flag_registration == null) { error.push('field registration required!'); }
		// if (data.id == "" && today > start_active) { error.push('start_registration must greater than today'); }
		if (data.flag_registration == 1 && start_registration > end_registration) { error.push('end_registration must greater than start_registration'); }
		// if (data.flag_registration == 1 && end_registration > start_active) { error.push('start_active must greater than end_registration'); }
		if (start_active > end_active) { error.push('end_active must greater than start_active'); }
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

	function prepareGiftAddPoints(target,refresh) {
		event.preventDefault();
		if ($(target).hasClass('process')) { return false; }
		$(target).toggleClass('process');
		var tId = $(target).data('id');
		if (checkPrepareId(target) == false) { return false; }
		var points = [];
		$.each($('.gift.add-point'), function () {
			if ($(this).val() != '' && $(this).val() != undefined) {
				var point = {};
				point['id'] = $(this).data('id');
				point['point'] = $(this).val();
				points.push(point);
			}
		});
		if(points.length == 0){
			$(target).toggleClass('process');
			pnotify({"title":"info","type":"info","text":"Not Add Points!"});
			return false;
		}
		$('.gift.add-point').val(null);
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

	function buildInGiftList(config) {
		var result = '';
        if (config.data.length == 0) {
            result += '<tr><td colspan="7" class="text-center">Not data found!</td></tr>';
        }else{
        	var loop = 0;
            $.each(config.data, function(index, val){
            	loop++;
                result += '<tr id='+val.id+'>';
                result += '<td>'+val.confirm_at+'</td>';
                result += '<td>'+val.participants_website+'</td>';
                result += '<td>'+val.participants_username+'</td>';
                result += '<td>'+val.participants_name+'</td>';
                result += '<td>'+val.participants_point_turnover+'</td>';
                result += '<td>'+val.have_coupon+'</td>';
                result += '<td><input data-id="'+val.id+'" class="gift add-point form-control" type="number" step="100" placeholder="add turnover point" ></td>';
                result += '</tr>';
                result += '<tr>';
				result += '<td>Coupon : </td>';
                result += '<td colspan="6">';
				if (val.has_coupon_code.length > 0) {
					var code = '';
					$.each(val.has_coupon_code, function(idx, cou){
						code += cou.coupon_code+', ';
					});
					code = code.substr(0, code.length-2);
					result += code;
				}else{
					result += '-';
				}
                result += '</td>';
                result += '</tr>';
            });
        }
        $(config.target+' table#render tbody').html(result);
        $(config.target+' .card-header .card-title strong').html(config.event.title);
		$(config.target+' .pagination .page-item a.page-link').data('id',config.event.id);
		$(config.target+' #importWrapper button').removeAttr('disabled');
		$(config.target+' #importWrapper #importExcelFile').data('id',config.event.id);
		prepareFormAddParticipants(config.event.id, config.website);
		prepareFormExchangeCode(config.event.id, config.couponcode);
	}

	function prepareFormAddParticipants(eventid, website) {
		$('#formInputAddPerticipants .input').val(null).removeAttr('disabled');
		$('#formInputAddPerticipants [name=id]').val(eventid);
		$('#formInputAddPerticipants button').removeAttr('disabled');
		$('#formInputAddPerticipants [name=website]').html(null);
		$.each(website,function(key,val){ $('#formInputAddPerticipants [name=website]').append("<option value='"+val+"'>"+val+"</option>") });
	}

	function prepareFormExchangeCode(eventid, couponcode) {
		$('#formExchangeCode .input').val(null).removeAttr('disabled').attr('required','true');
		$('#formExchangeCode .input').attr('min',couponcode.min);
		$('#formExchangeCode .input').attr('max',couponcode.max);
		$('#formExchangeCode [name=id]').val(eventid);
		$('#formExchangeCode button').removeAttr('disabled');
	}

	function clickTarget(target) {
		$(target).focus().trigger('click');
	}

	function prepareGenerateCoupon(target,refresh) {
		event.preventDefault();
		var tId = $(target).data('id');
		if (checkPrepareId(target) == false) { return false; }
		pnotifyConfirm({
            "title" : "Warning",
            "type" : "info",
            "text" : "Are You Sure Generate Coupon?",
            "formData" : false,
            "data" : {'id':tId,'target':refresh},
            "url" : $(target).attr('href')
        });
	}

	function prepareFilterList(target) {
		var input = {};
		$.each($("form#formInputAddPerticipants").find('.input'), function() {
			if ($(this).hasClass('select')) { input[$(this).attr('name')] = $(this).find('option:selected').val() }
			else{ input[$(this).attr('name')] = $(this).val() }
		});
		preparePostData(target,input);
	}

	$(document).on('submit', 'form#formExchangeCode', function(){
		var input = {};
		input['form_id'] = $(this).attr('id');
		$.each($(this).find('.input'), function() { input[$(this).attr('name')] = $(this).val() });
		pnotifyConfirm({
			"title": "Warning",
			"type": "info",
			"text": "Are You Sure To Exchange this coupon code?",
			"formData": false,
			"data": input,
			"url": $(this).attr('action')
		});
		return false;
	});

	$(document).on('submit', 'form#formInputAddPerticipants', function(){
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
			readExcelFile(evt.target.files[0],"{{ route('panel.event.coupon.importaddparticipants') }}",$(this).data('id'));
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
if(data.buildInGiftList == true){ buildInGiftList(data.buildInGiftList_config); }
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