@extends('panel._layouts.base')

@section('title')
{{ $config['page']['title'] }}
@endsection

@push('link')
<style type="text/css">
	#custom-tabs-coupon tbody tr{
		cursor: pointer;
	}
	#custom-tabs-coupon tbody tr.selected{
		background-color: #aab7d1;
	}
</style>
@endpush

@push('script')
@include('panel._componen.dtables_script', ['config' => $config['dtable']])
<script type="text/javascript">
	let urlOfTourne = "{!! route('panel.master.participants.tourne') !!}";
	let urlOfCoupon = "{!! route('panel.master.participants.coupon') !!}";

	$(document).on('click', '#custom-tabs-coupon tbody tr', function(){
		$(this).toggleClass('selected');
	});

	function getAgainRegisterTourne(id) {
		var page = $('#custom-tabs-participantsshow-tab').data('pagetourne');
		page = parseInt(page)+1;
		$('#custom-tabs-participantsshow-tab').data('pagetourne',page);

		postData({'id':id,'page':page},urlOfTourne);
	}

	function change_page_tourne(page) {
		$('#custom-tabs-participantsshow-tab').data('pagetourne',page);
	}

	function getAgainCoupon(id) {
		var page = $('#custom-tabs-participantsshow-tab').data('pagecoupon');
		page = parseInt(page)+1;
		$('#custom-tabs-participantsshow-tab').data('pagecoupon',page);

		postData({'id':id,'page':page},urlOfCoupon);
	}

	function change_page_coupon(page) {
		$('#custom-tabs-participantsshow-tab').data('pagecoupon',page);
	}
</script>
@endpush

@push('script.documentreadyfunction')
@include('panel._componen.dtables_script_documentreadyfunction')
@endpush

@push('script.responsePostData')
@include('panel._componen.dtables_script_responsePostData')
if(data.change_page_tourne == true) { change_page_tourne(data.change_page_tourne_val) }
if(data.change_page_coupon == true) { change_page_coupon(data.change_page_coupon_val) }
@endpush

@push('content')
@include('panel._componen.tabs', ['config' => $config['page']['tabs']])
@endpush