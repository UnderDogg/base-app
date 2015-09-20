<ul class="nav navbar-left navbar-nav">
    <li class="{{ active()->route('issues.index') }}">
        <a href="{{ route('issues.index') }}">
            <i class="fa fa-exclamation-circle"></i> Open Issues
        </a>
    </li>
    <li class="{{ active()->route('issues.closed') }}" >
        <a href="{{ route('issues.closed') }}">
            <i class="fa fa-check"></i> Closed Issues
        </a>
    </li>
    <li><a href="{{ route('issues.create') }}"><i class="fa fa-plus"></i> New Issue</a></li>
</ul>

@include('pages.issues._search')
