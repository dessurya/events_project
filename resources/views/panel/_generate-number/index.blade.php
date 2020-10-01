@extends('panel._layouts.base')

@section('title')
Generate Number Configuration
@endsection

@push('link')
@endpush

@push('script')
<script>
    function setConfigGenerateNumb() {
        var input = {};
        $.each($('#setConfigGenerateNumb').find('.input'), function(){ input[$(this).attr('name')] = parseInt($(this).val()) });
        if (input['min'] > input['max']) {
            pnotify({"title":"info","type":"dangger","text":"minimal number tidak boleh lebih besar dari maksimal number"})
            return false
        }
        if (input['digits'] > input['max'].toString().length) {
            pnotify({"title":"info","type":"dangger","text":"digits number tidak boleh lebih besar dari panjang maksimal number"})
            return false
        }
        $('#addNumbGenertResult').find('input[name=number]').attr('min',input['min']).attr('max',input['max'])
        postData(input, "{{ route('panel.generate-number.setconfig') }}")
    }

    function addNextGenerateResultNumb() {
        var numb = $('#addNumbGenertResult').find('.input').val()
        var min = $('#addNumbGenertResult').find('.input').attr('min')
        var max = $('#addNumbGenertResult').find('.input').attr('max')
        if (numb > max) {
            pnotify({"title":"info","type":"dangger","text":"number tidak boleh lebih besar dari maksimal number"})
            return false
        }else if (numb < min) {
            pnotify({"title":"info","type":"dangger","text":"number tidak boleh lebih kecil dari minimal number"})
            return false
        }
        postData({'next_numb':numb}, "{{ route('panel.generate-number.addnextnumb') }}")
    }

    function refreshNumbHistory() {
        postData(null, "{{ route('panel.generate-number.history') }}");
    }

    function prepareRGNH(data) {
        var queue = 1;
        var render = '';
        $.each(data.history, function(idx, val){
            render += "<tr>";
            render += "<td>"+val+"</td>";
            render += "<td>"+queue+"</td>";
            render += "</tr>";
            queue += 1;
        });
        $('#RenderGNH tbody').html(render);
        $('#RenderGNH small').html('('+data.live_time+')');
    }

    function refreshNumbNextResult() {
        postData(null, "{{ route('panel.generate-number.nextresult') }}");
    }

    function prepareRGNNR(data) {
        var render = '';
        $.each(data, function(idx, val){
            render += "<tr>";
            render += "<td>"+val+"</td>";
            render += "<td>"+(idx+1)+"</td>";
            render += "<td>";
            render += '<button onclick="upNextResult('+idx+')" title="up queue" ><i class="fas fa-angle-double-up"></i></button>'
            render += '<button onclick="deleteNextResult('+idx+')" title="delete" ><i class="fas fa-trash-alt"></i></button>'
            render += "</td>";
            render += "</tr>";
        });
        $('#RenderGNNR tbody').html(render);
    }

    function deleteNextResult(idx) {
        postData({'idx_numb':idx}, "{{ route('panel.generate-number.deletequeuenextnumb') }}")
    }
    function upNextResult(idx) {
        if (idx == 0) { 
            pnotify({"title":"info","type":"dangger","text":"number sudah menjadi urutan paling pertama"}) 
            return false
        }
        postData({'idx_numb':idx}, "{{ route('panel.generate-number.upqueuenextnumb') }}")
    }

    function changeFlagUse() {
        var flagUse = $('#flagUse').find('.input').val()
        postData({'flagUse':flagUse}, "{{ route('panel.generate-number.flaguse') }}")
    }
</script>
@endpush

@push('script.documentreadyfunction')
    refreshNumbHistory()
    refreshNumbNextResult()
@endpush

@push('script.responsePostData')
    if(data.prepareRenderGNH == true) { prepareRGNH(data.prepareRenderDataGNH) }
    if(data.prepareRenderGNNR == true) { prepareRGNNR(data.prepareRenderDataGNNR) }
@endpush

@push('content')
<div class="col-12 col-sm-12">
    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-tab" role="tablist">
                <li class="nav-item">
                    <a 
                        class="nav-link active" 
                        id="custom-tabs-list-tab" 
                        data-toggle="tab" 
                        href="#custom-tabs-list">Configuration</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-list">
                <div id="setConfigGenerateNumb" class="container mt-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Config Range Number</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="container p-2">
                                <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>periode time (menit)</label>
                                        <input required name="periode" type="number" min="10" step="5" value="{{ $setting['periode'] }}" class="form-control input">
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>digits</label>
                                        <input required name="digits" type="number" min="1" max="6" value="{{ $setting['digits'] }}" class="form-control input">
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Min</label>
                                        <input required name="min" type="number" min="1" max="9998" value="{{ $setting['min'] }}" class="form-control input">
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Max</label>
                                        <input required name="max" type="number" min="1" max="9999" value="{{ $setting['max'] }}" class="form-control input">
                                    </div>
                                    </div>
                                    <div class="col-md-12">
                                    <div class="form-group">
                                        <button onclick="setConfigGenerateNumb()" class="btn btn-primary btn-block">Submit</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div id="addNumbGenertResult" class="col-md-6">
                        <div class="container mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Add Number Result</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="container p-2">
                                        <div class="row">
                                            <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Number</label>
                                                <input required name="number" type="number" min="{{ $setting['min'] }}" max="{{ $setting['max'] }}" class="form-control input">
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <button onclick="addNextGenerateResultNumb()" class="btn btn-primary btn-block">Submit</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="flagUse" class="col-md-6">
                        <div class="container mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Number Result Flag</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="container p-2">
                                        <div class="row">
                                            <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Active/Inactive Number Next Result</label>
                                                <select required name="flag_use" class="form-control input">
                                                    <option value="Active" {{ $generate_number_set_result == 'Active' ? 'selected' : ''}}>Active</option>
                                                    <option value="Inactive" {{ $generate_number_set_result == 'Inactive' ? 'selected' : ''}}>Inactive</option>
                                                </select>
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <button onclick="changeFlagUse()" class="btn btn-primary btn-block">Submit</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div id="RenderGNNR" class="col-md-6">
                        <div class="container mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Number Result Set</h3>
                                    <div class="card-tools">
                                        <ul class="pagination pagination-sm float-right">
                                            <li class="page-item">
                                            <button 
                                                onclick="refreshNumbNextResult()"
                                                title="refresh"
                                                ><i class="fas fa-sync-alt"></i></button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="container p-2">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Number</th>
                                                    <th>Queue</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="RenderGNH" class="col-md-6">
                        <div class="container mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Number Result History Result <small></small></h3>
                                    <div class="card-tools">
                                        <ul class="pagination pagination-sm float-right">
                                            <li class="page-item">
                                            <button 
                                                onclick="refreshNumbHistory()"
                                                title="refresh"
                                                ><i class="fas fa-sync-alt"></i></button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="container p-2">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Number</th>
                                                    <th>Queue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endpush