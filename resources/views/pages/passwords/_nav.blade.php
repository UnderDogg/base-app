<ul class="nav navbar-left navbar-nav">
    <li class="{{ active()->route('passwords.index') }}">
        <a href="{{ route('passwords.index') }}">
            <i class="fa fa-tag"></i> All Passwords
        </a>
    </li>
    <li>
        <a href="{{ route('passwords.create') }}">
            <i class="fa fa-plus"></i> New Password
        </a>
    </li>
    <li>
        <a
                href="{{ route('passwords.gate.lock') }}"
                data-post="POST"
                data-title="Are you sure?"
                data-message="If you lock your passwords you'll need to re-enter your pin to access them."
                >
            <i class="fa fa-lock"></i> Lock Passwords
        </a>
    </li>
    <li>
        <a href="{{ route('passwords.pin.change') }}">
            <i class="fa fa-refresh"></i> Change PIN
        </a>
    </li>
</ul>
