@extends('_layouts.base')

@section('title')
{{ $config['page']['title'] }}
@endsection

@push('link')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/summernote/summernote-bs4.min.css') }}">
@endpush

@push('script')
<script type="text/javascript" src="{{ asset('vendors/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">
	function summernote(target) {

		window.setTimeout(function() { 
			$.each(target, function(index, val){
				$(val).summernote();
			});
		}, 1200);
	}
</script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
@include('_componen.dtables_script', ['config' => $config['dtable']])
@endpush

@push('script.documentreadyfunction')
@include('_componen.dtables_script_documentreadyfunction')
@endpush

@push('script.responsePostData')
@include('_componen.dtables_script_responsePostData')
if(data.summernote == true) { summernote(data.summernote_target); }
@endpush

@push('content')
@include('_componen.tabs', ['config' => $config['page']['tabs']])
@endpush