<ul class="nav navbar-left navbar-nav">
    <li class="{{ active()->route('passwords.index') }}">
        <a href="{{ route('passwords.index') }}">
            <i class="fa fa-tag"></i> All Passwords
        </a>
    </li>
    <li><a href="{{ route('passwords.create') }}"><i class="fa fa-plus"></i> New Password</a></li>
</ul>
