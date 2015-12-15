<ul class="nav navbar-left navbar-nav">
    <li class="{{ active()->route('resources.guides.index') }}">
        <a href="{{ route('resources.guides.index') }}">
            All Guides
        </a>
    </li>
    @can('create', App\Models\Guide::class)
    <li><a href="{{ route('resources.guides.create') }}"><i class="fa fa-plus"></i> New Guide</a></li>
    @endcan
</ul>

@include('pages.issues._search')
