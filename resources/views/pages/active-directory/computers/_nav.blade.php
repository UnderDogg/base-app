<ul class="nav navbar-left navbar-nav">
    <li class="{{ active()->route('issues.index') }}">
        <a
                data-post="POST"
                data-title="Are you sure?"
                data-message="Are you sure you want to add all computers?"
                href="{{ route('issues.index') }}">
            <i class="fa fa-plus"></i> Add All
        </a>
    </li>
</ul>

@include('pages.active-directory.computers._search')
