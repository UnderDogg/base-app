<ul class="nav nav-pills nav-stacked">

    <li role="presentation" class="{{ active()->routes(['profile.show', 'profile.edit']) }}">

        <a title="Update your Details" href="{{ route('profile.show') }}">
            <i class="fa fa-info-circle"></i>
            Details
        </a>

    </li>

    <li role="presentation" class="{{ active()->routes(['profile.avatar']) }}">

        <a title="Change your Avatar" href="{{ route('profile.avatar') }}">
            <i class="fa fa-user"></i>
            Avatar
        </a>

    </li>

    <li role="presentation" class="{{ active()->route('profile.password') }}">

        <a title="Change Your Password" href="{{ route('profile.password') }}">
            <i class="fa fa-lock"></i>
            Change Password
        </a>

    </li>

</ul>
