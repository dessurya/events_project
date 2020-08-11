<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
	</ul>

	<ul class="navbar-nav ml-auto">
		<li class="nav-item">
			<a class="nav-link" href="{{ route('self-data') }}" role="button" alt="profile" title="Profile">
				<i class="fas fa-id-card-alt"></i>
	        </a>
	    </li>
		<li class="nav-item">
			<a class="nav-link" href="{{ route('signout') }}" role="button" alt="sign-out" title="sign out">
				<i class="fas fa-sign-out-alt"></i>
	        </a>
	    </li>
	</ul>
</nav>