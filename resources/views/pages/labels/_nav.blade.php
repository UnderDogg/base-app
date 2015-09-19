<ul class="nav navbar-left navbar-nav">
    <li class="{{ isActiveRoute('labels.index') }}">
        <a href="{{ route('issues.index') }}">
            <i class="fa fa-tag"></i> All Labels
        </a>
    </li>
    <li><a href="{{ route('labels.create') }}"><i class="fa fa-plus"></i> New Label</a></li>
</ul>

@include('pages.labels._search')
