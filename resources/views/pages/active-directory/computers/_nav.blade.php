<ul class="nav navbar-left navbar-nav">
    <li>
        <a
                data-post="POST"
                data-title="Are you sure?"
                data-message="Are you sure you want to add all computers?"
                href="{{ route('active-directory.computers.store.all') }}">
            <i class="fa fa-plus"></i> Add All
        </a>
    </li>
</ul>

@include('pages.active-directory.computers._search')
