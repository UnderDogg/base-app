<ul class="nav navbar-left navbar-nav">
    <li>
        <a href="{{ route('computers.patches.create', [$computer->id]) }}">
            <i class="fa fa-plus"></i> Create
        </a>
    </li>
</ul>

@include('components.search')
