<div class="header-area">
	<div class="main-header ">
		
		<div class="header-mid d-none d-md-block">
			<div class="container">
				<div class="row d-flex align-items-center">
					<div class="col-xl-3 col-lg-3 col-md-3">
						<div class="logo">
							<a href="#">
								<img style="max-height: 50px;" src="{{ App\Http\Controllers\Azn\HomeController::interfaceGetLogo() }}">
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="header-bottom header-sticky">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-xl-10 col-lg-10 col-md-12 header-flex">
						<div class="sticky-logo">
							<a href="#">
								<img style="max-height: 50px;" src="{{ App\Http\Controllers\Azn\HomeController::interfaceGetLogo() }}">
							</a>
						</div>
						<div class="main-menu d-none d-md-block">
							<nav>
								<ul id="navigation">
									<li><a href="{{ route('azn.home.index') }}">Home</a></li>
									<li>
										<a href="{{ route('azn.event.index') }}">Our Event</a>
										<ul class="submenu">
											<li><a href="{{ route('azn.event.ongoing') }}">On Going</a></li>
											<li><a href="{{ route('azn.event.upcomming') }}">Upcoming</a></li>
											<li><a href="{{ route('azn.event.past') }}">Past</a></li>
										</ul>
									</li>
									<li><a href="{{ route('azn.contact.index') }}">Contact Us</a></li>
								</ul>
							</nav>
						</div>
					</div>
					<div class="col-xl-2 col-lg-2 col-md-4">
						<div class="header-right-btn f-right d-none d-lg-block">
							<i class="fas fa-search special-tag"></i>
							<div class="search-box">
								<form action="{{ route('azn.event.search') }}" method="get">
									<input type="text" placeholder="Search" name="search">
								</form>
							</div>
						</div>
					</div>
					<div class="col-12">
                        <div class="mobile_menu d-block d-md-none"></div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>