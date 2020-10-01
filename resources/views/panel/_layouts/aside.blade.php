<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<a href="{{ route('panel.dashboard') }}" class="brand-link">
      <img src="{{ asset('vendors/adminlte-dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Panel Events</span>
    </a>

    <div class="sidebar">
    	<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    		<div class="image">
    			<img src="{{ asset('vendors/adminlte-dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
    		</div>
    		<div class="info">
    			<a href="{{ route('panel.self-data') }}" class="d-block">{{ Auth::guard('users')->user()->name }}</a>
    		</div>
    	</div>

    	<nav class="mt-2">
    		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    			<li class="nav-item">
    				<a href="{{ route('panel.dashboard') }}" class="nav-link {{ Route::is('panel.dashboard') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-tachometer-alt"></i>
    					<p>Dashboard</p>
    				</a>
    			</li>
				<li class="nav-item {{ Route::is('panel.master*') ? 'menu-open' : '' }}">
    				<a href="#" class="nav-link {{ Route::is('panel.master*') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-database"></i>
    					<p>Master Data<i class="fas fa-angle-left right"></i></p>
    				</a>
    				<ul class="nav nav-treeview">
						<li class="nav-item">
    						<a href="{{ route('panel.master.bank.list') }}" class="nav-link {{ Route::is('panel.master.bank.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Bank</p>
    						</a>
    					</li>
    					<li class="nav-item">
    						<a href="{{ route('panel.master.website.list') }}" class="nav-link {{ Route::is('panel.master.website.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Website</p>
    						</a>
    					</li>
						<li class="nav-item">
    						<a href="{{ route('panel.master.participants.list') }}" class="nav-link {{ Route::is('panel.master.participants.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Participants</p>
    						</a>
    					</li>
    				</ul>
    			</li>
    			<li class="nav-item {{ Route::is('panel.event*') ? 'menu-open' : '' }}">
    				<a href="#" class="nav-link {{ Route::is('panel.event*') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-chess-rook"></i>
    					<p>Event Management<i class="fas fa-angle-left right"></i></p>
    				</a>
    				<ul class="nav nav-treeview">
    					<li class="nav-item">
							<a href="{{ route('panel.event.tournament.list') }}" class="nav-link {{ Route::is('panel.event.tournament.list') ? 'active' : '' }}">
								<i class="far fa-circle nav-icon"></i>
								<p>Tournament TO</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('panel.event.coupon.list') }}" class="nav-link {{ Route::is('panel.event.coupon.list') ? 'active' : '' }}">
								<i class="far fa-circle nav-icon"></i>
								<p>Coupon</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="{{ route('panel.event.other.list') }}" class="nav-link {{ Route::is('panel.event.other.list') ? 'active' : '' }}">
								<i class="far fa-circle nav-icon"></i>
								<p>Other</p>
							</a>
						</li>
						<li class="nav-item">
    						<a href="{{ route('panel.event.history.list') }}" class="nav-link {{ Route::is('panel.event.history.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>History</p>
    						</a>
    					</li>
    				</ul>
    			</li>
				<li class="nav-item {{ Route::is('panel.register*') ? 'menu-open' : '' }}">
    				<a href="#" class="nav-link {{ Route::is('panel.register*') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-file"></i>
    					<p>Register Management<i class="fas fa-angle-left right"></i></p>
    				</a>
    				<ul class="nav nav-treeview">
    					<li class="nav-item {{ Route::is('panel.register.tournament*') ? 'menu-open' : '' }}">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-circle"></i>
								<p>Tournament TO<i class="right fas fa-angle-left"></i></p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="{{ route('panel.register.tournament.list.new') }}" class="nav-link {{ Route::is('panel.register.tournament.list.new') ? 'active' : '' }}">
										<i class="far fa-circle nav-icon"></i>
										<p>New</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('panel.register.tournament.list.reject') }}" class="nav-link {{ Route::is('panel.register.tournament.list.reject') ? 'active' : '' }}">
										<i class="far fa-circle nav-icon"></i>
										<p>Reject</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('panel.register.tournament.list.history') }}" class="nav-link {{ Route::is('panel.register.tournament.list.history') ? 'active' : '' }}">
										<i class="far fa-circle nav-icon"></i>
										<p>History</p>
									</a>
								</li>
							</ul>
    					</li>
						<li class="nav-item {{ Route::is('panel.register.coupon*') ? 'menu-open' : '' }}">
							<a href="#" class="nav-link">
								<i class="nav-icon fas fa-circle"></i>
								<p>Coupon<i class="right fas fa-angle-left"></i></p>
							</a>
							<ul class="nav nav-treeview">
								<li class="nav-item">
									<a href="{{ route('panel.register.coupon.list.new') }}" class="nav-link {{ Route::is('panel.register.coupon.list.new') ? 'active' : '' }}">
										<i class="far fa-circle nav-icon"></i>
										<p>New</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('panel.register.coupon.list.reject') }}" class="nav-link {{ Route::is('panel.register.coupon.list.reject') ? 'active' : '' }}">
										<i class="far fa-circle nav-icon"></i>
										<p>Reject</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('panel.register.coupon.list.history') }}" class="nav-link {{ Route::is('panel.register.coupon.list.history') ? 'active' : '' }}">
										<i class="far fa-circle nav-icon"></i>
										<p>History</p>
									</a>
								</li>
							</ul>
    					</li>
    				</ul>
    			</li>
				<?php 
				// <li class="nav-item">
    			// 	<a href="{{ route('panel.coupon.list') }}" class="nav-link {{ Route::is('panel.coupon.list') ? 'active' : '' }} ">
    			// 		<i class="nav-icon fas fa-gifts"></i>
    			// 		<p>Coupon Management</p>
    			// 	</a>
				// </li>
				?>
				<li class="nav-item {{ Route::is('panel.interface*') ? 'menu-open' : '' }}">
    				<a href="#" class="nav-link {{ Route::is('panel.interface*') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-solar-panel"></i>
    					<p>Setting Interface<i class="fas fa-angle-left right"></i></p>
    				</a>
					<ul class="nav nav-treeview">
    					<li class="nav-item">
    						<a href="{{ route('panel.interface.list') }}" class="nav-link {{ Route::is('panel.interface.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Basic</p>
    						</a>
    					</li>
						<li class="nav-item">
    						<a href="{{ route('panel.interface.runningtext.list') }}" class="nav-link {{ Route::is('panel.interface.runningtext.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Running Text</p>
    						</a>
    					</li>
						<li class="nav-item">
    						<a href="{{ route('panel.interface.mainslider.list') }}" class="nav-link {{ Route::is('panel.interface.mainslider.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Main Slider</p>
    						</a>
    					</li>
						<li class="nav-item">
    						<a href="{{ route('panel.interface.contact.list') }}" class="nav-link {{ Route::is('panel.interface.contact.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Contact</p>
    						</a>
    					</li>
					</ul>
    			</li>
				<li class="nav-item {{ Route::is('panel.user*') ? 'menu-open' : '' }}">
    				<a href="#" class="nav-link {{ Route::is('panel.user*') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-cogs"></i>
    					<p>User Management<i class="fas fa-angle-left right"></i></p>
    				</a>
    				<ul class="nav nav-treeview">
    					<li class="nav-item">
    						<a href="{{ route('panel.user.list') }}" class="nav-link {{ Route::is('panel.user.list') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>List</p>
    						</a>
    					</li>
    					<li class="nav-item">
    						<a href="{{ route('panel.user.logs') }}" class="nav-link {{ Route::is('panel.user.logs') ? 'active' : '' }}">
    							<i class="far fa-circle nav-icon"></i>
    							<p>Logs</p>
    						</a>
    					</li>
    				</ul>
    			</li>
				<li class="nav-item">
    				<a href="{{ route('panel.generate-number.index') }}" class="nav-link {{ Route::is('panel.generate-number.index') ? 'active' : '' }} ">
    					<i class="nav-icon fas fa-stopwatch-20"></i>
    					<p>Generate Number Config</p>
    				</a>
    			</li>
    		</ul>
    	</nav>
    </div>
	
	<div id="render_some_action"></div>
</aside>