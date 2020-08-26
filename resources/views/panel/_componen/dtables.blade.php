<div class="row">
    <div class="col-12">    
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div id="dTableAction" class="input-group">
                        <div class="input-group-append">
                            <button class="btn btn-info" onclick="rebuildTable()";>
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button class="btn btn-info" onclick="toogleClass('hide', '#{{ $config['table_id'] }} input')";>
                                <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="true">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu" style="">
                                @foreach($config['action'] as $list)
                                <a 
                                    class="dropdown-item action-item"
                                    data-action="{{ $list['action'] }}"
                                    data-select="{{ $list['select'] }}"
                                    data-confirm="{{ $list['confirm'] }}"
                                    data-multiple="{{ $list['multiple'] }}"
                                    href="{{ route($list['route']) }}">{{$list['title']}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-tools">
                    <label class="tabel-info">Show <select name="show" class="rebuildTable">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> entries || Order By <select name="order_key" class="rebuildTable">
                        @foreach($config['componen'] as $list)
                        @if($list['orderable'] == true)
                        <option {{ $config['order']['key'] == $list['name'] ? 'selected' : '' }} value="{{$list['name']}}">{{ str_replace('_',' ',Str::title($list['name'])) }}</option>
                        @endif
                        @endforeach
                    </select> : <select name="order_val" class="rebuildTable">
                        <option {{ $config['order']['value'] == 'asc' ? 'selected' : '' }} value="asc">ASC</option>
                        <option {{ $config['order']['value'] == 'desc' ? 'selected' : '' }} value="desc">DESC</option>
                    </select></label>
                </div>
            </div>
            <div class="card-body table-responsive p-0" style="height: auto; max-height: 480px;">
                <table id="{{ $config['table_id'] }}" class="table table-head-fixed text-nowrap selected-table">
                    <thead>
                        <tr role="row">
                            <form class="getData">
                            @foreach($config['componen'] as $list)
                            <th>
                                {{ str_replace('_',' ',Str::title($list['name'])) }}
                                @if($list['searchable'] == true)
                                @if($list['searchtype'] == 'date')
                                <input 
                                    type="{{$list['searchtype']}}" 
                                    name="from_{{$list['name']}}" 
                                    class="form-control rebuildTable hide" 
                                    placeholder="From Date">
                                <input 
                                    type="{{$list['searchtype']}}" 
                                    name="to_{{$list['name']}}" 
                                    class="form-control rebuildTable hide" 
                                    placeholder="To Date">
                                @elseif($list['searchtype'] == 'text')
                                <input 
                                    type="{{$list['searchtype']}}" 
                                    name="{{$list['name']}}" 
                                    class="form-control rebuildTable hide" 
                                    placeholder="Search {{ str_replace('_',' ',Str::title($list['name'])) }}">
                                @endif
                                @endif
                            </th>
                            @endforeach
                            </form>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="card-footer">
                <div style="float: left;">
                    <span class="tabel-info">
                        Showing <strong id="from"></strong> to <strong id="to"></strong> of <strong id="total"></strong> entries
                    </span>
                </div>
                <div class="tabel-info" style="float: right;">
                    <label>Pages <input type="number" name="page" class="rebuildTable" min="1"> from <strong id="last_page"></strong></label>
                </div>
            </div>
        </div>
    </div>
</div>