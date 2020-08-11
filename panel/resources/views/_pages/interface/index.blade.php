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
@endpush

@push('script.documentreadyfunction')
@include('_componen.dtables_script_documentreadyfunction')
@endpush

@push('script.responsePostData')
@include('_componen.dtables_script_responsePostData')
@include('_componen.summernote_script_responsePostData')
@endpush

@push('content')
@include('_componen.tabs', ['config' => $config['page']['tabs']])
@endpush