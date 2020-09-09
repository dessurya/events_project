<script>
    const urlgetdatauser = '{!! route($config['get_data_route']) !!}';
    const componenTable = jQuery.parseJSON('{!! json_encode($config['componen']) !!}');
    const rendorTableBodyOn = '#{!! $config['table_id'] !!} tbody';
</script>
<script type="text/javascript" src="{{ asset('asset/js/dtable.js') }}?v=0.2"></script>