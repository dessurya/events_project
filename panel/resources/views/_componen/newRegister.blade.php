<li class="nav-header">Warning</li>
@if($tourne > 0)
<li class="nav-item">
    <a href="{{ route('register.tournament.list') }}" class="nav-link">
        <i class="nav-icon far fa-circle text-danger"></i>
        <p class="text">Tournament <span class="badge bg-danger">{{$tourne}}</span></p>
    </a>
</li>
@endif
@if($coupon > 0)
<li class="nav-item">
    <a href="{{ route('register.coupon.list') }}" class="nav-link">
        <i class="nav-icon far fa-circle text-danger"></i>
        <p class="text">Coupon <span class="badge bg-danger">{{$coupon}}</span></p>
    </a>
</li>
@endif