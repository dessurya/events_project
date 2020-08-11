<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{ asset('vendors/adminlte-dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Panel Events</span>
    </a>

    <div class="sidebar">
    	<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    		<div class="image">
    			<img src="{{ asset('vendors/adminlte-dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
    		</div>
    		<div class="info">
    			<a href="{{ route('self-data') }}" class="d-block">{{ Auth::guard('users')->user()->name }}</a>
    		</div>
    	</div>

    	<nav class="mt-2">
    		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    			<li class="nav-item">
    				<a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-tachometer-alt"></i>
    					<p>Dashboard</p>
    				</a>
    			</li>
    			<li class="nav-item">
    				<a href="#" class="nav-link {{ Route::is('user*') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-cogs"></i>
    					<p>User Management<i class="fas fa-angle-left right"></i></p>
    				</a>
    				<ul class="nav nav-treeview">
    					<li class="nav-item">
    						<a href="{{ route('user.list') }}" class="nav-link {{ Route::is('user.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>List</p>
    						</a>
    					</li>
    					<li class="nav-item">
    						<a href="{{ route('user.logs') }}" class="nav-link {{ Route::is('user.logs') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Logs</p>
    						</a>
    					</li>
    				</ul>
    			</li>
				<li class="nav-item">
    				<a href="#" class="nav-link {{ Route::is('master*') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-database"></i>
    					<p>Master Data<i class="fas fa-angle-left right"></i></p>
    				</a>
    				<ul class="nav nav-treeview">
    					<li class="nav-item">
    						<a href="{{ route('master.website.list') }}" class="nav-link {{ Route::is('master.website.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Website</p>
    						</a>
    					</li>
						<li class="nav-item">
    						<a href="{{ route('master.participants.list') }}" class="nav-link {{ Route::is('master.participants.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Participants</p>
    						</a>
    					</li>
    				</ul>
    			</li>
				
				<li class="nav-item">
    				<a href="#" class="nav-link {{ Route::is('interface*') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-solar-panel"></i>
    					<p>Interface Management<i class="fas fa-angle-left right"></i></p>
    				</a>
					<ul class="nav nav-treeview">
    					<li class="nav-item">
    						<a href="{{ route('interface.list') }}" class="nav-link {{ Route::is('interface.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Basic</p>
    						</a>
    					</li>
						<li class="nav-item">
    						<a href="{{ route('interface.runningtext.list') }}" class="nav-link {{ Route::is('interface.runningtext.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Running Text</p>
    						</a>
    					</li>
						<li class="nav-item">
    						<a href="{{ route('interface.mainslider.list') }}" class="nav-link {{ Route::is('interface.mainslider.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Main Slider</p>
    						</a>
    					</li>
					</ul>
    			</li>
				<li class="nav-item">
    				<a href="#" class="nav-link {{ Route::is('event*') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-chess-rook"></i>
    					<p>Event Management<i class="fas fa-angle-left right"></i></p>
    				</a>
    				<ul class="nav nav-treeview">
    					<li class="nav-item">
    						<a href="{{ route('event.tournament.list') }}" class="nav-link {{ Route::is('event.tournament.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Tournament TO</p>
    						</a>
    					</li>
    					<li class="nav-item">
    						<a href="{{ route('event.coupon.list') }}" class="nav-link {{ Route::is('event.coupon.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Coupon</p>
    						</a>
    					</li>
						<li class="nav-item">
    						<a href="{{ route('event.other.list') }}" class="nav-link {{ Route::is('event.other.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Other</p>
    						</a>
    					</li>
    				</ul>
    			</li>
				<li class="nav-item">
    				<a href="#" class="nav-link {{ Route::is('register*') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-file-alt"></i>
    					<p>Register Management<i class="fas fa-angle-left right"></i></p>
    				</a>
    				<ul class="nav nav-treeview">
    					<li class="nav-item">
    						<a href="{{ route('register.tournament.list') }}" class="nav-link {{ Route::is('register.tournament.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Tournament TO</p>
    						</a>
    					</li>
    					<li class="nav-item">
    						<a href="{{ route('register.coupon.list') }}" class="nav-link {{ Route::is('register.coupon.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Coupon</p>
    						</a>
    					</li>
						<li class="nav-item">
    						<a href="{{ route('register.other.list') }}" class="nav-link {{ Route::is('register.other.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Other</p>
    						</a>
    					</li>
    				</ul>
    			</li>
    		</ul>
    	</nav>
    </div>
</aside>