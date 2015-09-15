<header class="navbar navbar-default navbar-static-top" id="top" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{ route('welcome.index') }}" class="navbar-brand">IT Hub</a>
        </div>
        <nav id="bs-navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                @if(auth()->check())
                <li>
                    <a href="{{ route('issues.index') }}">Issues</a>
                </li>
                @endif
                <li>
                    <a href="/">Resources</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(auth()->check())
                    <li><a href="{{ route('auth.logout') }}">Logout</a></li>
                @else
                    <li><a href="{{ route('auth.login.index') }}">Login</a></li>
                @endif
            </ul>
        </nav>
    </div>
</header>
