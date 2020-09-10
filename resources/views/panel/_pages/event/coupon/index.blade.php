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
		if (data.id == "" && today > start_active) { error.push('start_registration must greater than today'); }
		if (data.flag_registration == 1 && start_registration > end_registration) { error.push('end_registration must greater than start_registration'); }
		if (data.flag_registration == 1 && end_registration > start_active) { error.push('start_active must greater than end_registration'); }
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

	function preparePostData(target) {
		event.preventDefault();
		var tId = $(target).data('id');
		if (checkPrepareId(target) == false) { return false; }
		postData({"id":tId}, $(target).attr('href'));
	}

	function prepareGiftCoupon(target,refresh) {
		event.preventDefault();
		if ($(target).hasClass('process')) { return false; }
		$(target).toggleClass('process');
		var tId = $(target).data('id');
		if (checkPrepareId(target) == false) { return false; }
		var coupons = [];
		$.each($('.gift.gift-coupon'), function () {
			if ($(this).val() != '' && $(this).val() != undefined) {
				var coupon = {};
				coupon['id'] = $(this).data('id');
				coupon['coupon'] = $(this).val();
				coupons.push(coupon);
			}
		});
		if(coupons.length == 0){
			$(target).toggleClass('process');
			pnotify({"title":"info","type":"info","text":"Not Gift Coupon"});
			return false;
		}
		$('.gift.gift-coupon').val(null);
		pnotifyConfirm({
            "title" : "Warning",
            "type" : "info",
            "text" : "Are You Sure Gift All Coupons?",
            "formData" : false,
            "data" : {'event_id':tId,'coupons':coupons,'target':refresh},
            "url" : $(target).attr('href')
        });
		$(target).toggleClass('process');
	}

	function buildInGiftList(config) {
		var result = '';
        if (config.data.length == 0) {
            result += '<tr><td colspan="6" class="text-center">Not data found!</td></tr>';
        }else{
        	var loop = 0;
            $.each(config.data, function(index, val){
            	loop++;
                result += '<tr id='+val.id+'>';
                result += '<td>'+val.confirm_at+'</td>';
                result += '<td>'+val.participants_website+'</td>';
                result += '<td>'+val.participants_username+'</td>';
                result += '<td>'+val.participants_name+'</td>';
                result += '<td>'+val.have_coupon+'</td>';
                result += '<td><input data-id="'+val.id+'" class="gift gift-coupon form-control" type="number" placeholder="add coupon" ></td>';
                result += '</tr>';
            });
        }
        $(config.target+' table tbody').html(result);
        $(config.target+' .card-header .card-title strong').html(config.event.title);
        $(config.target+' .pagination .page-item a.page-link').data('id',config.event.id);
	}
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