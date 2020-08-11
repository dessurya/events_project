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
		var start_activity = new Date(data.start_activity);
		var end_activity = new Date(data.end_activity);
		var today = new Date();

		if (data.id == null && today > start_registration) {
			error.push('start_registration must greater than today');
		}
		if (start_registration > end_registration) {
			error.push('end_registration must greater than start_registration');
		}
		if (end_registration > start_activity) {
			error.push('start_activity must greater than end_registration');
		}
		if (start_activity > end_activity) {
			error.push('end_activity must greater than start_activity');
		}
		if(error.length > 0){
			$.each(error, function(index, val){
				pnotify({"title":"info","type":"dangger","text":val});
			});
			return true;
		}
		return false;
	}

	function preparePostData(target) {
		event.preventDefault();
		var tId = $(target).data('id');
		if (tId == "" || tId == null) {
			pnotify({"title":"info","type":"dangger","text":"Warning! not selected event!"});
			return false;
		}
		postData({"id":tId}, $(target).attr('href'));
	}

	function buildInLeaderboard(config) {
		var result = '';
        if (config.data.length == 0) {
            result += '<tr><td colspan="5" class="text-center">Not data found!</td></tr>';
        }else{
        	var loop = 0;
            $.each(config.data, function(index, val){
            	loop++;
                result += '<tr id='+val.id+'>';
                result += '<td>'+loop+'</td>';
                result += '<td>'+val.participants_username+'</td>';
                result += '<td>'+val.participants_name+'</td>';
                result += '<td>'+val.participants_point_board+'</td>';
                result += '<td>'+val.participants_rank_board+'</td>';
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
if(data.buildInLeaderboard == true){ buildInLeaderboard(data.buildInLeaderboard_config); }
@endpush

@push('script.postDataBeforeSend')
if(url == "{!! $config['route_validate'] !!}"){
	var checkValidate = validateForm(data);
	if(checkValidate.error == true){
		return false;
	}
}
@endpush


@push('content')
@include('_componen.tabs', ['config' => $config['page']['tabs']])
@endpush