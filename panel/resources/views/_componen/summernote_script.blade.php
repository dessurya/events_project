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