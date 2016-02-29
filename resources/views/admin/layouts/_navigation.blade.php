<header class="navbar navbar-default navbar-static-top" id="top" role="banner">

    <div class="container">

        <div class="navbar-header">

            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a href="{{ route('admin.welcome.index') }}" class="navbar-brand">
                Administration
            </a>

        </div>

        <nav id="bs-navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav">

                @if(auth()->check())

                    <li class="dropdown {{ active()->resource('admin.users') }}" id="admin-users-menu">
                        <a  href="#admin-users-menu" rel="admin-users-menu" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-users"></i>
                            Users
                            <i class="fa fa-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="{{ active()->resource('admin.users') }}">
                                <a href="{{ route('admin.users.index') }}">
                                    <i class="fa fa-list"></i>
                                    All Users
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown {{ active()->resource('admin.roles') }}" id="admin-roles-menu">
                        <a  href="#admin-roles-menu" rel="admin-roles-menu" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user-md"></i>
                            Roles
                            <i class="fa fa-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="{{ active()->resource('admin.roles') }}">
                                <a href="{{ route('admin.roles.index') }}">
                                    <i class="fa fa-list"></i>
                                    All Roles
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown {{ active()->resource('admin.permissions') }}" id="admin-permissions-menu">
                        <a  href="#admin-permissions-menu" rel="admin-permissions-menu" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-check-circle-o"></i>
                            Permissions
                            <i class="fa fa-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="{{ active()->resource('admin.permissions') }}">
                                <a href="{{ route('admin.permissions.index') }}">
                                    <i class="fa fa-list"></i>
                                    All Permissions
                                </a>
                            </li>
                        </ul>
                    </li>

                @endif

            </ul>

            <ul class="nav navbar-nav navbar-right">

                @if(auth()->check())

                    <li class="dropdown" id="user-menu">

                        <a href="#user-menu" rel="user-menu" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }}
                            <i class="fa fa-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a href="{{ route('welcome.index') }}">
                                    <i class="fa fa-reply"></i>
                                    Back to Helpdesk
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a class="force-reload" href="{{ route('admin.auth.logout') }}">
                                    <i class="fa fa-sign-out"></i> Logout
                                </a>
                            </li>

                        </ul>

                    </li>

                @else

                    <li>
                        <a href="{{ route('admin.auth.login') }}">
                            Login
                        </a>
                    </li>

                @endif

            </ul>

        </nav>

    </div>

</header>
