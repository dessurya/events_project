<div class="col-12 col-sm-12">
    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="{{$config['id_head']}}" role="tablist">
                @foreach($config['tab'] as $tab)
                <li class="nav-item">
                    <a 
                        class="nav-link {{ $tab['active'] == true ? 'active' : ''}}" 
                        id="{{$tab['id']}}" 
                        data-toggle="tab" 
                        href="#{{$tab['href']}}">{{ Str::title($tab['name']) }}</a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="{{$config['id_content']}}">
                @foreach($config['tab'] as $tab)
                <div 
                    class="tab-pane fade {{ $tab['active'] == true ? 'active show' : '' }}" 
                    id="{{$tab['href']}}" >
                    {!! $tab['content'] !!}
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>