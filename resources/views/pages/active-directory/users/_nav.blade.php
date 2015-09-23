<ul class="nav navbar-left navbar-nav">
    <li class="{{ active()->route('issues.index') }}">
        <a
                data-post="POST"
                data-title="Are you sure?"
                data-message="Are you sure you want to add all users?"
                href="{{ route('active-directory.users.index') }}">
            <i class="fa fa-plus"></i> Add All
        </a>
    </li>
</ul>

@include('pages.active-directory.users._search')
