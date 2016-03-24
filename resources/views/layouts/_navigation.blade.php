<header class="navbar navbar-default navbar-static-top" id="top" role="banner">

    <div class="container">

        <div class="navbar-header">

            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a href="{{ route('welcome.index') }}" class="navbar-brand">
                {{ env('APP_NAME', 'Helpdesk') }}
            </a>

        </div>

        <nav id="bs-navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav">

                <li class="dropdown {{ active()->route('resources.*') }}" id="resources-menu">

                    <a  href="#resources-menu" rel="resources-menu" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-info-circle"></i>
                        Resources
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu">

                        <li class="{{ active()->route('resources.guides.*') }}">

                            <a href="{{ route('resources.guides.index') }}">
                                <i class="fa fa-book"></i>
                                Guides
                            </a>

                        </li>

                    </ul>

                </li>

                @if(auth()->check())

                    <li class="dropdown {{ active()->route('inquiries.*') }}" id="requests-menu">

                        <a  href="#requests-menu" rel="requests-menu" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-question-circle"></i>
                            Requests
                            <i class="fa fa-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">

                            <li class="{{ active()->resource('inquiries') }}">

                                <a href="{{ route('inquiries.index') }}">
                                    <i class="fa fa-bell"></i>
                                    Requests
                                </a>

                            </li>

                            @if(\App\Policies\CategoryPolicy::index(auth()->user()))

                                <li class="{{ active()->route('inquiries.categories.*') }}">

                                    <a href="{{ route('inquiries.categories.index') }}">
                                        <i class="fa fa-folder"></i>
                                        Categories
                                    </a>

                                </li>

                            @endif

                        </ul>

                    </li>

                    <li class="dropdown {{ active()->routes(['issues.*', 'labels.*']) }}" id="issues-menu">

                        <a href="#issues-menu" rel="issues-menu" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ticket"></i>
                            Tickets
                            <i class="fa fa-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">

                            <li class="{{ active()->route('issues.*') }}">

                                <a href="{{ route('issues.index') }}">
                                    <i class="fa fa-ticket"></i>
                                    Tickets
                                </a>

                            </li>

                            @if(\App\Policies\LabelPolicy::index(auth()->user()))

                                <li class="{{ active()->route('labels.*') }}">
                                    <a href="{{ route('labels.index') }}">
                                        <i class="fa fa-tags"></i>
                                        Labels
                                    </a>
                                </li>

                            @endif

                        </ul>

                    </li>

                    @if(\App\Policies\ServicePolicy::index(auth()->user()))

                        <li class="{{ active()->route('services.*') }}">
                            <a href="{{ route('services.index') }}">
                                <i class="fa fa-server"></i>
                                Services
                            </a>
                        </li>

                    @endif

                    @if(\App\Policies\Device\ComputerPolicy::index(auth()->user()))

                        <li class="dropdown {{ active()->route('devices.computers.*') }}" id="computers-menu">

                            <a href="#computers-menu" rel="computers-menu" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-desktop"></i>
                                Computers
                                <i class="fa fa-caret-down"></i>
                            </a>

                            <ul class="dropdown-menu">

                                <li class="{{ active()->route('devices.computer-types.*') }}">

                                    <a href="{{ route('devices.computer-types.index') }}">
                                        <i class="fa fa-sitemap"></i>
                                        Types
                                    </a>

                                </li>

                                <li class="{{ active()->route('devices.computer-systems.*') }}">

                                    <a href="{{ route('devices.computer-systems.index') }}">
                                        <i class="fa fa-windows"></i>
                                        Operating Systems
                                    </a>

                                </li>

                                <li class="divider"></li>

                                <li class="{{ active()->route('devices.computers.*') }}">

                                    <a href="{{ route('devices.computers.index') }}">
                                        <i class="fa fa-list"></i>
                                        All Computers
                                    </a>

                                </li>

                            </ul>

                        </li>

                    @endif

                    @if(\App\Policies\Device\DrivePolicy::index(auth()->user()))

                        <li class="{{ active()->route('devices.drives.*') }}">
                            <a href="{{ route('devices.drives.index') }}">
                                <i class="fa fa-hdd-o"></i>
                                Drives
                            </a>
                        </li>

                    @endif

                @endif

            </ul>

            <ul class="nav navbar-nav navbar-right">

                @if(auth()->check())

                    <li class="dropdown {{ active()->routes(['profile.*', 'passwords.*', 'security-questions.*']) }}" id="user-menu">

                        <a href="#user-menu" rel="user-menu" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }}
                            <i class="fa fa-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">

                            <li class="text-center">
                                <img src="{{ auth()->user()->avatar_url }}" alt="User Profile Image">
                            </li>

                            <li class="divider"></li>

                            <li class="{{ active()->route('profile.*') }}">
                                <a href="{{ route('profile.show') }}">
                                    <i class="fa fa-user"></i> Profile
                                </a>
                            </li>

                            <li class="{{ active()->route('passwords.*') }}">
                                <a href="{{ route('passwords.index') }}">
                                    <i class="fa fa-lock"></i> Passwords
                                </a>
                            </li>

                            <li class="{{ active()->route('security-questions.*') }}">
                                <a href="{{ route('security-questions.index') }}">
                                    <i class="fa fa-question-circle"></i> Security Questions
                                </a>
                            </li>

                            <li class="divider"></li>

                            @if(\App\Policies\AdminAccessPolicy::index(auth()->user()))
                                <li>
                                    <a href="{{ route('admin.welcome.index') }}">
                                        <i class="fa fa-user-md"></i> Administration
                                    </a>
                                </li>
                            @endif

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
