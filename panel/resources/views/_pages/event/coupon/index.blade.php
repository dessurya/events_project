@extends('_layouts.base')

@section('title')
{{ $config['page']['title'] }}
@endsection

@push('link')
@include('_componen.summernote_link')
@endpush

@push('script')
@include('_componen.summernote_script', ['config' => $config['dtable']])
@include('_componen.dtables_script', ['config' => $config['dtable']])
<script type="text/javascript">
	function validateForm(data) {
		var error = [];
		var start_registration = new Date(data.start_registration);
		var end_registration = new Date(data.end_registration);
		var start_active = new Date(data.start_active);
		var end_active = new Date(data.end_active);
		var today = new Date();

		if (data.id == "" && today >= start_active) {
			error.push('start_registration must greater than today');
		}
		if (start_registration > end_registration) {
			error.push('end_registration must greater than start_registration');
		}
		if (end_registration > start_active) {
			error.push('start_active must greater than end_registration');
		}
		if (start_active > end_active) {
			error.push('end_active must greater than start_active');
		}
		if(error.length > 0){
			$.each(error, function(index, val){
				pnotify({"title":"info","type":"dangger","text":val});
			});
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

	function buildInGiftList(config) {
		var result = '';
        if (config.data.length == 0) {
            result += '<tr><td colspan="3" class="text-center">Not data found!</td></tr>';
        }else{
        	var loop = 0;
            $.each(config.data, function(index, val){
            	loop++;
                result += '<tr id='+val.id+'>';
                result += '<td>'+val.confirm_at+'</td>';
                result += '<td>'+val.participants_username+'</td>';
                result += '<td>'+val.participants_name+'</td>';
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
@include('_componen.dtables_script_documentreadyfunction')
@endpush

@push('script.responsePostData')
@include('_componen.dtables_script_responsePostData')
@include('_componen.summernote_script_responsePostData')
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
@include('_componen.tabs', ['config' => $config['page']['tabs']])
@endpush