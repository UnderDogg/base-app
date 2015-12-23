<ul class="nav nav-pills nav-stacked">
    <li role="presentation" class="{{ active()->route('profile.show') }}">
        <a title="Details" href="{{ route('profile.show') }}">
            <i class="fa fa-info-circle"></i>
            Details
        </a>
    </li>
    <li role="presentation" class="{{ active()->route('profile.password') }}">
        <a title="Change Password" href="{{ route('profile.password') }}">
            <i class="fa fa-lock"></i>
            Change Password
        </a>
    </li>
</ul>
