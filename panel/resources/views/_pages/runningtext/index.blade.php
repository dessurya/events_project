@extends('_layouts.base')

@section('title')
{{ $config['page']['title'] }}
@endsection

@push('link')
@endpush

@push('script')
@include('_componen.dtables_script', ['config' => $config['dtable']])
@endpush

@push('script.documentreadyfunction')
@include('_componen.dtables_script_documentreadyfunction')
@endpush

@push('script.responsePostData')
@include('_componen.dtables_script_responsePostData')
@endpush

@push('content')
@include('_componen.tabs', ['config' => $config['page']['tabs']])
@endpush