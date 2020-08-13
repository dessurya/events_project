@extends('_layouts.base')

@section('title')
Dashboard
@endsection

@push('content')
    <div class="col-12">
        <div class="row">
            <div class="col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $config['new_regiter_tourne_to'] }}</h3>
                        <p>New Registrations Tournament TO</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="{{ route('register.tournament.list') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>-</h3>
                        <p>New Registrations Coupon</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tournament TO</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($config['count_event'] as $item)
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box {{ $item['bg_class'] }}">
                            <span class="info-box-icon"><i class="far fa-{{ $item['icon'] }}"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ Str::title($item['name']) }}</span>
                                <span class="info-box-number">{{ $item['number'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endpush