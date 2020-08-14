@extends('panel._layouts.base')

@section('title')
{{ $config['page']['title'] }}
@endsection

@push('link')
@include('panel._componen.summernote_link')
@endpush

@push('script')
@include('panel._componen.summernote_script', ['config' => $config['dtable']])
@include('panel._componen.dtables_script', ['config' => $config['dtable']])
@endpush

@push('script.documentreadyfunction')
@include('panel._componen.dtables_script_documentreadyfunction')
@endpush

@push('script.responsePostData')
@include('panel._componen.dtables_script_responsePostData')
@include('panel._componen.summernote_script_responsePostData')
@endpush

@push('content')
@include('panel._componen.tabs', ['config' => $config['page']['tabs']])
@endpush