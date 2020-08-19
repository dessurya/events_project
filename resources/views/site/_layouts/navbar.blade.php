<nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ route('site.home.index') }}">
        <img src="{{ App\Http\Controllers\Site\HomeController::interfaceGetIcon() }}" width="45" height="45" alt="{{ App\Http\Controllers\Site\HomeController::interfaceGetTitle() }} Icon">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item {{ Route::is('site.home.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('site.home.index') }}">Home</a>
            </li>
            <li class="nav-item {{ Route::is('site.event*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('site.event.index') }}">Our Event</a>
            </li>
            <li class="nav-item {{ Route::is('site.contact.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('site.contact.index') }}">Contact Us</a>
            </li>
        </ul>
        <form action="{{ route('site.event.search') }}" method="get" class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>