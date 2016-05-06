<ul class="nav navbar-left navbar-nav">

    <li class="{{ active()->route('labels.index') }}">
        <a href="{{ route('labels.index') }}">
            <i class="fa fa-tag"></i> All Labels
        </a>
    </li>

    @can('manage.labels')
        <li><a href="{{ route('labels.create') }}"><i class="fa fa-plus"></i> New Label</a></li>
    @endcan

</ul>

