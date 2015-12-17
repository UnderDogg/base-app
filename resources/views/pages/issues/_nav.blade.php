<ul class="nav navbar-left navbar-nav">

    <li class="{{ active()->route('issues.index') }}">
        <a href="{{ route('issues.index') }}">
            <i class="fa fa-exclamation-circle"></i> Open Issues
        </a>
    </li>

    <li class="{{ active()->route('issues.closed') }}" >
        <a href="{{ route('issues.closed') }}">
            <i class="fa fa-check-circle"></i> Closed Issues
        </a>
    </li>

    <li class="dropdown">

        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-tags"></i>
            Labels
            <i class="fa fa-caret-down"></i>
        </a>

        <ul class="dropdown-menu dropdown-menu-labels">
            @foreach($labels as $label)
                <li>
                    <a href="#">
                        {!! $label->getDisplayLarge() !!}
                    </a>
                </li>
            @endforeach
        </ul>

    </li>

    <li>
        <a href="{{ route('issues.create') }}">
            <i class="fa fa-plus-square"></i> New Issue
        </a>
    </li>

</ul>

@include('pages.issues._search')
