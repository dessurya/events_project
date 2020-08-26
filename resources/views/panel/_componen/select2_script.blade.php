<script type="text/javascript" src="{{ asset('vendors/select2/js/select2.full.min.js') }}"></script>
<script>
var targetSelect2 = '.select2bs4';
$(targetSelect2).select2({
    theme: 'bootstrap4'
});

function select2_valset(data) {
    $(targetSelect2).val(data);
    $(targetSelect2).trigger('change');
}
</script>