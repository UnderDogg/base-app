<ul class="nav navbar-left navbar-nav">
    <li class="{{ (Request::is('issues') ? 'active' : null) }}"><a href="{{ route('issues.create') }}"><i class="fa fa-warning"></i> Open Issues</a></li>
    <li><a class="{{ (Request::is('issues/closed') ? 'active' : null) }}" href="{{ route('issues.index') }}"><i class="fa fa-check"></i> Closed Issues</a></li>
    <li><a href="{{ route('issues.create') }}"><i class="fa fa-plus"></i> New Issue</a></li>
</ul>

@include('pages.issues._search')
