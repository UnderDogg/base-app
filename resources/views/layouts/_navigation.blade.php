<header class="navbar navbar-default navbar-static-top" id="top" role="banner">

    <div class="container">

        <div class="navbar-header">

            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a href="{{ route('welcome.index') }}" class="navbar-brand">{{ memorize('site.name', 'IT Hub') }}</a>

        </div>

        <nav id="bs-navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav">

                @if(auth()->check())

                    <li class="dropdown {{ active()->routes(['issues.*', 'labels.*']) }}" id="issues-menu">
                        <a href="#issues-menu" rel="issues-menu" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-exclamation-circle"></i>
                            Issues
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">

                            <li class="{{ active()->route('issues.index') }}">
                                <a href="{{ route('issues.index') }}">
                                    <i class="fa fa-exclamation-circle"></i>
                                    Open Issues
                                </a>
                            </li>

                            <li class="{{ active()->route('issues.closed') }}">
                                <a href="{{ route('issues.closed') }}">
                                    <i class="fa fa-check"></i>
                                    Closed Issues
                                </a>
                            </li>

                            @can('index', App\Models\Label::class)
                            <li class="{{ active()->route('labels.index') }}">
                                <a href="{{ route('labels.index') }}">
                                    <i class="fa fa-tag"></i>
                                    Labels
                                </a>
                            </li>
                            @endcan

                        </ul>
                    </li>
                @endif
                <li>
                    <a href="/">Resources</a>
                </li>

            </ul>

            <ul class="nav navbar-nav navbar-right">

                @if(auth()->check())
                    <li class="dropdown" id="user-menu">
                        <a href="#user-menu" rel="user-menu" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->fullname }}
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('auth.logout') }}">
                                    <i class="fa fa-sign-out"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ route('auth.login.index') }}">
                            Login
                        </a>
                    </li>
                @endif

            </ul>

        </nav>

    </div>

</header>
