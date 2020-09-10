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

	function validateForm(data) {
		if (data.flag_gs_n_date == 2) { return false; }
		var error = [];
		var start_activity = new Date(data.start_activity);
		var end_activity = new Date(data.end_activity);
		var today = new Date();
		if (data.id == "" && today >= start_activity) { error.push('start_activity must greater than today'); }
		if (start_activity > end_activity) { error.push('end_activity must greater than start_activity'); }
		if(error.length > 0){
			$.each(error, function(index, val){ pnotify({"title":"info","type":"dangger","text":val}); });
			return true;
		}
		return false;
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